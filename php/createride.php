<?php
session_start();

if (!isset($_SESSION['driver'])) {
    $feedback = "Session expired. Please login again.";
    header("Location: ../driver.php");
    exit();
}

include 'connect.php';

$busid = $_POST['busid'];
$routeid = $_POST['routeid'];
$status = "Scheduled";

date_default_timezone_set('Africa/Nairobi');
$current_time = date('H:i');

$schedule_times = [
    '11:30',
    '14:30',
    '17:30'
];

$departure_schedule = null;
foreach ($schedule_times as $time) {
    if ($current_time < $time) {
        $departure_schedule = $time;
        break;
    }
}

if ($departure_schedule === null) {
    $feedback = "No available schedule times.";
    header("Location: ../Driver.php?feedback=".$feedback);
    exit();
}

$arrivaltime = date('H:i', strtotime($departure_schedule . ' +1 hour'));

print $arrivaltime;

$sql = "INSERT INTO schedules(Route_ID, departure_time, arrival_time, BusID, Schedule_status) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssss", $routeid, $departure_schedule, $arrivaltime, $busid, $status);
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

header("Location: ../Driver.php?feedback=".$feedback);
exit();
?>
