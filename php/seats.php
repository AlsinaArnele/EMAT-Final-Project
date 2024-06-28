<?php
if (isset($_COOKIE['unbooked_seats'])) {
    $unbooked_seats = $_COOKIE['unbooked_seats'];
    $bottomDisplay = "flex";
    $routedisplay = '<input type="text" name="route2" id="route2" readonly value="' . $_SESSION["route"] . '">';
    $timedisplay = '<input type="text" name="time2" id="time2" readonly value="' . $_SESSION["time"] . '">';
    $selectdisplay = 'none';
}
else{
    $bottomDisplay = "none";
    $routedisplay = '';
    $timedisplay = '';
    $selectdisplay = 'flex';
}
?>