<?php
require_once "db_config.php"; 

$userLoggedIn = false;
$username = "";

if (isset($_SESSION["username"])) {
    $userLoggedIn = true;
    $username = $_SESSION["username"];
}


?>
