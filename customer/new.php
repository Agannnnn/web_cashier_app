<?php
require_once "../config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (checkFormPost(["name", "phone_num"])) {
    if (
      !checkFormPost([
        'id',
        'name',
        'phone_num'
      ])
    ) {
      return header('Location: ' . DIR_APP);
    }

    $id = createID();
    $name = $conn->real_escape_string($_POST["name"]);
    $phone_num = $conn->real_escape_string($_POST["phone_num"]);

    $res = $conn->query("INSERT INTO `customer`(`id`, `fullname`, `phone_num`) VALUES ('$id', '$name', '$phone_num')");
    if ($res) {
      return header("Location: " . DIR_APP . "/customer");
    }
    http_response_code(505);
  }
}
?>

<?php require_once "../template_header.php" ?>

<!DOCTYPE html>
<html lang="en">

<body class="bg-light">
    <form action="<?= DIR_APP ?>/customer/new.php" method="POST"
        class="text-center shadow-sm p-3 mx-auto mt-5 rounded bg-white d-flex flex-column gap-1"
        style="max-width: 360px;">
        <h2 class="border-bottom border-2 border-dark py-2">New Customer</h2>
        <div class="form-floating my-1">
            <input type="text" name="name" id="inputName" class="form-control" placeholder="" autofocus>
            <label for="inputName">Name</label>
        </div>
        <div class="form-floating my-1">
            <input type="tel" name="phone_num" id="inputPhone" class="form-control" placeholder="">
            <label for="inputPhone">Phone Number</label>
        </div>
        <input type="submit" class="w-100 btn btn-lg btn-outline-primary" value="Save">
    </form>
</body>

</html>