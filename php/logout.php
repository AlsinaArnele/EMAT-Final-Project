<?php
session_start();
unset($_SESSION['mysession']);
unset($_SESSION['time']);
unset($_SESSION['route']);
header('Location: ../index.php');
?>
