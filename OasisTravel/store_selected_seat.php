<?php
session_start();

if ($_GET && isset($_GET['selectedSeat'])) {
    $_SESSION["seat"] = $_GET['selectedSeat'];
    header('Location: payment_page.php');
    exit();
}
?>
