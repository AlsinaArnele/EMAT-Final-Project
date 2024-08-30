<?php 
    session_start();
    if (!isset($_SESSION['driver'])) {
        $style = "style='display: flex;'";
    }else{
        include 'connect.php';
        $style = "style='display: none;'";
        $sql = 'SELECT * FROM `drivers` WHERE `driver_id` = ?';
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param('s', $_SESSION['driver']);
        $stmt -> execute();
        $result = $stmt -> get_result();
        $row = $result -> fetch_assoc();

        $sql2 = 'SELECT * FROM `buses` WHERE `driver_id` = ?';
        $stmt2 = $conn -> prepare($sql2);
        $stmt2 -> bind_param('s', $_SESSION['driver']);
        $stmt2 -> execute();
        $result2 = $stmt2 -> get_result();
        $row2 = $result2 -> fetch_assoc();
        $route = $row2['Route_name'];

        $sql3 = 'SELECT * FROM `routes` WHERE `Route_name` = ?';
        $stmt3 = $conn -> prepare($sql3);
        $stmt3 -> bind_param('s', $route);
        $stmt3 -> execute();
        $result3 = $stmt3 -> get_result();
        $row3 = $result3 -> fetch_assoc();
    }
?>