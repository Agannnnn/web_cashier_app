<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isFormValid = checkFormPost(['name', 'price', 'description']);

    if (!$isFormValid) {
        return header('Location: ' . DIR_APP);
    }
    if ($_POST['price'] < 0) {
        return header('Location: ' . DIR_APP . '/item/new.php');
    }

    $id = createID();
    $name = $conn->real_escape_string($_POST['name']);
    $price = $conn->real_escape_string($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);


    $query = "INSERT INTO `items` (`id`, `name`, `price`, `description`) VALUES ('$id', '$name', '$price', '$description');";
    if ($conn->query($query)) {
        return header('Location: ' . DIR_APP);
    }

    http_response_code(505);
    exit();
}
?>
<!DOCTYPE html>
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
    <form action="<?= DIR_APP ?>/item/new.php" method="POST"
        class="text-center shadow-sm p-3 rounded bg-white custom-width-sm">
        <h2 class="mb-3 border-bottom border-2 border-dark py-2">New Item</h2>
        <div class="form-floating my-1">
            <input type="text" name="name" id="inputName" class="form-control" placeholder="">
            <label for="inputName">Name</label>
        </div>
        <div class="my-1 d-flex input-group">
            <div class="input-group-text">Rp.</div>
            <div class="form-floating flex-fill">
                <input type="number" name="price" id="inputPrice" class="form-control" min="0" placeholder="">
                <label for="inputPrice">Price</label>
            </div>
        </div>
        <div class="form-floating my-1">
            <input type="text" name="description" id="inputDescription" class="form-control" placeholder="">
            <label for="inputDescription">Description</label>
        </div>
        <input type="submit" class="w-100 btn btn-lg btn-outline-success mt-2" value="Save">
    </form>
</body>