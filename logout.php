<script>
    localStorage.removeItem("cart")
</script>

<?php
session_start();
include_once "config.php";
session_destroy();
header("Location:" . DIR_APP . "/login.php");
