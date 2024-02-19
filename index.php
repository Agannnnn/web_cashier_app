<!DOCTYPE html>

<html lang="en">
<?php require_once 'template_header.php'; ?>

<body class="bg-light">
    <div class="container-lg shadow-sm my-5 rounded bg-white">
        <div class="row gap-2">
            <div class="col-8">
                <div class="row bg-primary text-light">
                    <h1 class="col">Items</h1>
                </div>
                <div class="row justify-content-start mb-4">
                    <?php
                    $query = "SELECT * FROM `items`;";
                    $boughtItem = mysqli_query($conn, $query);
                    while ($items = mysqli_fetch_assoc($boughtItem)): ?>
                    <div class="col-md-6 col-lg-4 gy-3">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <span><strong>
                                        <?= $items['name'] ?>
                                    </strong></span>
                            </div>
                            <div class="card-body">
                                <small class="text-mute">
                                    <?= $items['stock'] ?> in stock
                                </small>
                                <p>
                                    <?= $items['description'] ?>
                                </p>
                                <div class="btn-group w-100">
                                    <button data-id="<?= bin2hex($items['id']) ?>" data-name="<?= $items['name'] ?>"
                                        data-price="<?= $items['price'] ?>" data-stock="<?= $items['stock'] ?>"
                                        class="btn btn-outline-secondary" onclick="addToCart(this)"
                                        <?= $items['stock'] < 1 ? 'disabled' : '' ?>>
                                        Add To Cart
                                    </button>
                                    <a href="<?= DIR_APP ?>/item/edit.php?id=<?= bin2hex($items['id']) ?>"
                                        class="btn btn-outline-secondary">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile ?>
                </div>
            </div>
            <div class="col">
                <div class="row bg-primary text-light">
                    <h1 class="col">Cart</h1>
                </div>
                <div class="p-3 d-flex flex-column gap-3">
                    <ul class="list-group row d-flex overflow-auto" style="max-height: 250px;" id="cart-items"></ul>
                    <div class="input-group">
                        <span class="input-group-text">Customer</span>
                        <select name="idCustomer" id="inputIdCustomer" class="form-select">
                            <option value="01">Select A Customer</option>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM `customer`");
                            while ($customer = mysqli_fetch_assoc($query)):
                                ?>
                            <option value="<?= bin2hex($customer['id']) ?>">
                                <?= $customer['fullname'] ?> - ID:
                                <?= bin2hex($customer['id']) ?>
                            </option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <span id="price-total">Rp.0</span>
                    <button class="row btn btn-success" onclick="save()">Beli</button>
                </div>
            </div>
        </div>
    </div>
    <script src="scripts/home.js" defer async></script>
</body>

</html>