<?php
session_start();
unset($_SESSION['driver']);
header('Location: ../driver.php');
?>