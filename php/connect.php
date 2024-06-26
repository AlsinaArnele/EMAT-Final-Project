<?php 
    $servername = 'localhost';
    $username = 'root';
    $serverpassword = '';
    $dbname = 'ematBooking';

    $conn = new mysqli($servername, $username, $serverpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 ?>