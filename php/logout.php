<?php
session_start();
unset($_SESSION['mysession'], $_SESSION['seatID'], $_SESSION['route'], $_SESSION['time'], $_SESSION['price']);
session_destroy();
header('Location: ../index.php');
?>
