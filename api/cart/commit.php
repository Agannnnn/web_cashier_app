<?php
function error()
{
    http_response_code(401);
    die(json_encode(['status' => 'failed', 'code' => 401]));
}

if (!isset($_SERVER['HTTP_REFERER'])) {
    error();
} else if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error();
}

header('Content-Type: application/json');
require_once '../../config.php';

session_start();

// Create a new transactions record.
$conn->begin_transaction();
$id = createID();

try {
    $stmt = $conn->prepare('INSERT INTO `transactions` (`id`, `customer`, `cashier`) VALUES (?,?,?)');

    $cashier = $conn->escape_string($_SESSION["username"]);
    $customer = hex2bin($conn->escape_string($_POST["customer"]));
    $items = $_POST['items'];

    $stmt->bind_param('sss', $id, $customer, $cashier);
    $stmt->execute();

    /**
     * Creating a new record for every item into the details table.
     * Updating every item's stock based on qty of an item.
     */
    foreach ($items as $item) {
        $itemID = hex2bin($conn->real_escape_string($item['id']));
        $qty = $conn->real_escape_string($item['qty']);

        $stmt = $conn->prepare("INSERT INTO `details` (`item`, `qty`, `transaction`) VALUES (?,?,?)");
        $stmt->bind_param('sis', $itemID, $qty, $id);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE `items` SET `stock` = `stock` - ? WHERE `id` = ?");
        $stmt->bind_param('is', $qty, $itemID);
        $stmt->execute();
    }

    $conn->commit();
    http_response_code(200);
    die(json_encode(['status' => 'success', 'code' => 200]));
} catch (mysqli_sql_exception $exception) {
    $conn->rollback();
    http_response_code(400);
    die(json_encode(['status' => 'failed', 'code' => 400]));
}