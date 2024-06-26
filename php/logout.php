<?php
session_start();
unset($_SESSION['mysession']);
header('Location: ../index.php');
?>
