<?php
session_start();

if ($_POST && isset($_POST['selectedSeat'])) {
    $_SESSION['seat'] = $_POST['selectedSeat'];

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
