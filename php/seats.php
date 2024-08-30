<?php
if (isset($_COOKIE['unbooked_seats'])) {
    $sql = "SELECT BusNumber FROM buses WHERE driver_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['driver']);
    $stmt->execute();
    $stmt->bind_result($numberplate);
    $stmt->fetch();
    $stmt->close();

    $unbooked_seats = $_COOKIE['unbooked_seats'];
    $unbooked_seats = explode(",", $unbooked_seats);
    $rows = range('A', 'E');
    $columns = range(1, 4);
    $bottomDisplay = "visible";
    $routedisplay = '<input type="text" name="route2" id="route2" readonly value="' . $_SESSION["route"] . '">';
    $timedisplay = '<input type="text" name="time2" id="time2" readonly value="' . $_SESSION["time"] . '">';
    $selectdisplay = 'none';
}
else{
    $bottomDisplay = "hidden"; 
    $routedisplay = '';
    $timedisplay = ''; 
    $selectdisplay = 'flex';
}
?>