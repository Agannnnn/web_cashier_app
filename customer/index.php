<!DOCTYPE html>

<html lang="en">

<?php require_once "../template_header.php" ?>

<body class="bg-light">
    <div class="container-md shadow-sm bg-white mt-5">
        <div class="row bg-primary text-light">
            <h1 class="col">Customer</h1>
        </div>
        <div class="container py-3">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $query = $conn->query("SELECT * FROM `customer`");
                    while ($customer = $query->fetch_assoc()): ?>
                        <tr class="align-middle">
                            <td>
                                <?= bin2hex($customer['id']) ?>
                            </td>
                            <td>
                                <?= $customer['fullname'] ?>
                            </td>
                            <td>
                                <?= $customer['phone_num'] ?>
                            </td>
                            <td class="btn-group w-100">
                                <a href="<?= DIR_APP ?>/customer/edit.php?id=<?= bin2hex($customer['id']) ?>"
                                    class="btn btn-outline-primary">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <a href="<?= DIR_APP ?>/customer/new.php" class="btn btn-primary w-100">Add New</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>