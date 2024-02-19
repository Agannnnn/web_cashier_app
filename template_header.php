<?php
require_once __DIR__ . '/config.php';
session_start();
if ($_SERVER['REQUEST_URI'] !== DIR_APP . "/login.php") {
    if (!isset($_SESSION['fullname'])) {
        if (empty($_SESSION['fullname'])) {
            header("Location: " . DIR_APP . "/login.php");
            return;
        }
        header("Location: " . DIR_APP . "/login.php");
        return;
    }
}
define('PAGE_NAME', str_replace('.php', '', str_replace(DIR_APP . "/", '', $_SERVER['PHP_SELF'])));
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier |
        <?= str_replace('_', ' ', PAGE_NAME) ?>
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"
        defer>
        </script>
    <script src="<?= DIR_APP ?>/jquery.js"></script>
    <style>
        body {
            background-color: var(--bs-light);
        }

        .custom-width-lg {
            max-width: 800px;
        }

        .custom-width-sm {
            max-width: 400px;
        }
    </style>
</head>

<?php if (PAGE_NAME != 'login'): ?>
    <header class="d-flex justify-content-center py-3 shadow-sm bg-white" style="position: sticky; top: 0; z-index: 5;">
        <ul class="nav nav-pills gap-2">
            <li class="nav-item">
                <a href="<?= DIR_APP ?>" class="nav-link <?= PAGE_NAME === 'index' ? 'active' : '' ?>">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="<?= DIR_APP ?>/item/new.php" class="nav-link <?= PAGE_NAME === 'item/new' ? 'active' : '' ?>">New
                    Item</a>
            </li>
            <li class="nav-item">
                <a href="<?= DIR_APP ?>/customer"
                    class="nav-link <?= PAGE_NAME === 'customer/index' ? 'active' : '' ?>">Customer</a>
            </li>
            <li class="nav-item position-relative">
                <a href="<?= DIR_APP ?>/transactions"
                    class="nav-link <?= PAGE_NAME === 'transactions/index' ? 'active' : '' ?>">Transactions</a>
            </li>
            <li class="nav-item">
                <a href="<?= DIR_APP ?>/logout.php" class="nav-link text-light bg-danger">Logout</a>
            </li>
        </ul>
    </header>
<?php endif ?>