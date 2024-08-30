<?php
include 'driver-sessions.php';
include 'connect.php';

$busid = $_POST['busid'];
$routeid = $_POST['routeid'];
$deptime = $_POST['departure'];
$arrtime = $_POST['arrival'];
$status = "Scheduled";
$arrtime = date('Y-m-d H:i:s', strtotime($arrtime));
$deptime = date('Y-m-d H:i:s', strtotime($deptime));

$sql = "INSERT INTO schedules(Route_ID, departure_time, arrival_time, BusID, Schedule_status) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssss", $routeid, $deptime, $arrtime, $busid, $status);
    if ($stmt->execute()) {
        $feedback = "Ride Scheduled";
    } else {
        $feedback = "Error scheduling ride: " . $stmt->error;
    }
    $stmt->close();
} else {
    $feedback = "Error preparing statement: " . $conn->error;
}

$conn->close();

header("Location: ../pages/driver/Driver.php?feedback=".$feedback);
exit();
?>
