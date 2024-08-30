<?php
session_start();
if(isset($_SESSION['driver'])){
    session_destroy();
    header('Location: ../Driver.php');
    exit();
}
?>