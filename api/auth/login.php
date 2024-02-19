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

require_once '../../config.php';

$username = $conn->real_escape_string($_POST['username']);
$password = $conn->real_escape_string($_POST['password']);

if ($username == "" || $password == "") {
    http_response_code(401);
    die(json_encode(['status' => 'failed', 'code' => 401]));
}

$query = "SELECT `fullname` FROM `cashier` WHERE `username` = '$username' AND `password` = '$password'";
$user = $conn->query($query);

if ($user->num_rows == 1) {
    session_start();

    $user = $user->fetch_assoc();
    $_SESSION["fullname"] = $user["fullname"];
    $_SESSION["username"] = $username;

    http_response_code(200);
    die(json_encode(['status' => 'success', 'code' => 200, 'user' => $user]));
}

http_response_code(500);
die(json_encode(['status' => 'failed', 'code' => 500]));