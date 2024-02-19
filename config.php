<?php
if (basename($_SERVER['PHP_SELF'], '.php') === 'config') {
  die(404);
}

/**
 * Should be changed to '/' when deployed
 * Used in links when in development with XAMPP so the link wont
 * redirect to the root folder
 */
const DIR_APP = "/web_cashier_app";

const DB_HOST = "localhost";
const DB_USERNAME = "root";
const DB_PASSWORD = "";
const DB_NAME = "cashier";
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

function createID(): string
{
  return random_bytes(16);
}

function checkFormPost(array $inputs): bool
{
  foreach ($inputs as $input) {
    if (!isset($_POST[$input]) || empty($_POST[$input]))
      return $input;
  }
  return true;
}