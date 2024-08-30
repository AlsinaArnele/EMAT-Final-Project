<?php
session_start();
unset($_SESSION['driver']);
header('Location: ../pages/driver/driver.php');
?>