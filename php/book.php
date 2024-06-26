<?php
    include 'connect.php';
    $myemail = $_SESSION['mysession'];
    $mydate = date('Y-m-d H:i:s');

    $sql = "SELECT * FROM bookings WHERE `route`=? AND BookingDate=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $myroute, $mydate);
    $stmt->execute();
    $result = $stmt->get_result();
    $numrows = $result->num_rows;

    if ($numrows > 0) {
        $seatsArray = [];
        $booking = $result->fetch_assoc();
        $seatid = $booking['seat_ids'];
        $seatsArray = array_filter(array_map('trim', explode(',', $seatid)));
    }
?>
