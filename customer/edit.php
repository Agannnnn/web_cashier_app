<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        return header('Location: ' . DIR_APP);
    }
}

require_once '../config.php';

$id = $conn->real_escape_string($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !checkFormPost([
            'id',
            'name',
            'phone_num'
        ])
    ) {
        return header('Location: ' . DIR_APP, true, 505);
    }

    $id = hex2bin($conn->real_escape_string($_POST['id']));
    $name = $conn->real_escape_string($_POST['name']);
    $phone_num = $conn->real_escape_string($_POST['phone_num']);

    $query = "UPDATE `customer` SET `fullname` = '$name', `phone_num` = '$phone_num' WHERE `id` = '$id'";
    if ($conn->query($query)) {
        return header('Location: ' . DIR_APP . '/customer/edit.php?id=' . bin2hex($id));
    }
    http_response_code(505);
}

$query = $conn->query("SELECT * FROM `customer` WHERE `id` = '" . hex2bin($id) . "'");
if ($query->num_rows != 1) {
    http_response_code(404);
    exit();
}
$user = $query->fetch_assoc();
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
    <form action="<?= DIR_APP ?>/customer/edit.php?id=<?= $_GET['id'] ?>" method="POST"
        class="text-center shadow-sm p-3 rounded bg-white d-flex flex-column gap-1" style="max-width: 360px;">
        <h2 class="mb-3 border-bottom border-2 border-dark py-2">Edit Customer</h2>
        <input type="hidden" name="id" value="<?= bin2hex($user['id']) ?>">
        <div class="form-floating">
            <input type="text" name="name" id="inputName" class="form-control" value="<?= $user['fullname'] ?>">
            <label for="inputName">Name</label>
        </div>
        <div class="d-flex">
            <div class="form-floating flex-fill">
                <input type="tel" name="phone_num" id="inputPhoneNum" class="form-control"
                    value="<?= $user['phone_num'] ?>">
                <label for="inputPhoneNum">Phone Number</label>
            </div>
        </div>
        <div class="btn-group w-100 gap-1">
            <button type="submit" class="w-100 btn btn-lg btn-outline-success mt-2">Save</button>
        </div>
    </form>
</body>

</html>