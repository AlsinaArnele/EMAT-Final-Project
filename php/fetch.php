<?php
include 'connect.php';

$route = $_POST['route'];
$time = $_POST['time'];
$mydate = date('Y-m-d', strtotime($time));

$sql = "SELECT * FROM bookings WHERE `route`=? AND BookingDate=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $route, $mydate);
$stmt->execute();
$result = $stmt->get_result();
$numrows = $result->num_rows;

if ($numrows > 0) {
    $seatsArray = [];
    $booking = $result->fetch_assoc();
    $seatid = $booking['seat_ids'];
    $schedBus = $booking['busID'];
    $seatsArray = array_filter(array_map('trim', explode(',', $seatid)));

    // redirect to the booking page with the seats array
    header("Location: ../homepage.php?seats=" . urlencode(json_encode($seatsArray)) . "&bus=" . urlencode(json_encode($schedBus)));
} else {
    $feedback = "No rides found for the selected route and time";
    header("Location: ../homepage.php?message=" . urlencode( json_encode($feedback)));
}
?>
