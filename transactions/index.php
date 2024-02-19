<!DOCTYPE html>

<html lang="en">

<?php require_once "../template_header.php" ?>

<body class="bg-light">
    <div class="container-md shadow-sm bg-white mt-5">
        <div class="row bg-primary text-light">
            <h1 class="col">Transactions</h1>
        </div>
        <div class="container py-3">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Menu</th>
                        <th>Customer</th>
                        <th>Cashier</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $query = 'SELECT `transactions`.`id`, `customer`.`fullname` AS `customer_name`, `cashier`.`fullname` AS `cashier_name`
                        FROM ((`transactions` INNER JOIN `customer` ON `transactions`.`customer` = `customer`.`id`)
                        INNER JOIN `cashier` ON `transactions`.`cashier` = `cashier`.`username`)';
                    $transactions = $conn->query($query);

                    while ($transaction = $transactions->fetch_assoc()):
                        $query = "SELECT `details`.`qty`, `items`.`name` AS `menu_name`
                            FROM `details` INNER JOIN `items` ON `details`.`item` = `items`.`id`
                            WHERE `details`.`transaction` = '" . $transaction['id'] . "'";
                        $details = $conn->query($query);
                        ?>
                        <tr class="align-middle">
                            <td>
                                <?= bin2hex($transaction["id"]) ?>
                            </td>
                            <td>
                                <ul class="list-group">
                                    <?php while ($detail = mysqli_fetch_assoc($details)): ?>
                                        <li class="list-group-item d-flex flex-row justify-content-between">
                                            <span>
                                                <?= $detail['menu_name'] ?>
                                            </span>
                                            <span class="badge bg-secondary">
                                                <?= $detail['qty'] ?>
                                            </span>
                                        </li>
                                    <?php endwhile ?>
                                </ul>
                            </td>
                            <td>
                                <?= $transaction['customer_name'] ?>
                            </td>
                            <td>
                                <?= $transaction['cashier_name'] ?>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>