<?php
if(isset($_COOKIE['unbooked_seats'])){
    // destroy the cookie
    setcookie('unbooked_seats', '', time() - 3600, '/');
    header('Location: ../homepage.php');
}

?>