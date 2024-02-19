<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        return header('Location: ' . DIR_APP);
    }
}

$id = hex2bin($conn->real_escape_string($_GET['id']));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !checkFormPost([
            'id',
            'name',
            'price',
            'stock',
            'description'
        ])
    ) {
        return header('Location: ' . DIR_APP, true, 505);
    }

    $id = hex2bin($conn->real_escape_string($_POST['id']));
    $name = $conn->real_escape_string($_POST['name']);
    $price = $conn->real_escape_string($_POST['price']);
    $stock = $conn->real_escape_string($_POST['stock']);
    $description = $conn->real_escape_string($_POST['description']);

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("UPDATE `items` SET `name` = ?, `price` = ?, `stock` = ?, `description` = ? WHERE `id` = ?");
        $stmt->bind_param('sdiss', $name, $price, $stock, $description, $id);
        $stmt->execute();

        $conn->commit();
        return header('Location: ' . DIR_APP . '/item/edit.php?id=' . bin2hex($id));
    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        echo 'error';
        var_dump($exception->getMessage());
        exit(505);
    }
}
$query = $conn->query("SELECT * FROM `items` WHERE `id` = '$id'");
if ($query->num_rows != 1) {
    exit(404);
}
$boughtItem = $query->fetch_assoc();
?>

<html lang="en">

<head>
    <style>
        form {
            top: 50%;
            left: 50%;
            width: 100%;
            position: absolute;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<?php require_once "../template_header.php" ?>

<body class="bg-light">
    <form action="<?= DIR_APP ?>/item/edit.php?id=<?= $_GET['id'] ?>" method="POST"
        class="text-center shadow-sm p-3 rounded bg-white gap-1 d-flex flex-column" style="max-width: 420px;">
        <h2 class="mb-3 border-bottom border-2 border-dark py-2">Edit Item</h2>
        <input type="hidden" name="id" value="<?= bin2hex($boughtItem['id']) ?>">
        <div class="form-floating">
            <input type="text" name="name" id="inputName" class="form-control" value="<?= $boughtItem['name'] ?>">
            <label for="inputName">Name</label>
        </div>
        <div class="d-flex input-group">
            <div class="input-group-text">Rp.</div>
            <div class="form-floating flex-fill">
                <input type="number" name="price" id="inputPrice" class="form-control"
                    value="<?= $boughtItem['price'] ?>" min="0">
                <label for="inputPrice">Price</label>
            </div>
        </div>
        <div class="d-flex input-group">
            <div class="form-floating flex-fill">
                <input type="number" name="stock" id="inputStock" class="form-control"
                    value="<?= $boughtItem['stock'] ?>" autofocus>
                <label for="inputStock">Stock</label>
            </div>
            <div class="input-group-text">Portion</div>
        </div>
        <div class="d-flex input-group">
            <div class="form-floating flex-fill">
                <input type="text" name="description" id="inputDescription" class="form-control"
                    value="<?= $boughtItem['description'] ?>">
                <label for="inputDescription">Description</label>
            </div>
        </div>
        <div class="btn-group w-100 gap-2">
            <a href="<?= DIR_APP ?>" class="btn btn-lg btn-outline-primary">Return</a>
            <button type="submit" class="btn btn-lg btn-outline-success">Save</button>
        </div>
    </form>
</body>

</html>