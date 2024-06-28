<?php
session_start();
include 'connect.php';

$route = $_POST['route'];
$time = $_POST['time'];

if($time == "11"){
    $time = date("Y-m-d H:i:s", strtotime('11:30:00'));
}else if($time == "14"){
    $time = date("Y-m-d H:i:s", strtotime('14:30:00'));
}else{
    $time = date("Y-m-d H:i:s", strtotime('17:30:00'));
}

$sql = "SELECT * FROM schedules WHERE `Route_ID`=? AND departure_time=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $route, $time);
$stmt->execute();
$result = $stmt->get_result();
$numrows = $result->num_rows;

if ($numrows > 0) {
    $all_seats = [];
    $columns_labels = range('A', 'D');
    $columns = count($columns_labels);

    for ($i = 1; $i <= 7; $i++) {
        for ($j = 0; $j < $columns; $j++) {
            $all_seats[] = $i . $columns_labels[$j];
        }
    }

    $booked_seats = [];
    $sql = "SELECT seatID FROM bookings";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $booked_seats[] = $row['seatID'];
        }
        $unbooked_seats = array_diff($all_seats, $booked_seats);
    } else {
        $unbooked_seats = $all_seats;
    }

    $sql3 = "SELECT * FROM routes WHERE `Route_ID`=?";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("s", $route);
    $stmt3->execute();
    $result3 = $stmt3->get_result();
    $row3 = $result3->fetch_assoc();

    if(isset($_SESSION['time'])){
        unset($_SESSION['time']);
    }
    $_SESSION['time'] = $time;

    if(isset($_SESSION['route'])){
        unset($_SESSION['route']);
    }
    $_SESSION['route'] = $row3['Route_name'];

    $unbooked_seats = implode(',', $unbooked_seats);
    if(isset($_COOKIE['unbooked_seats'])){
        unset($_COOKIE['unbooked_seats']);
    }
    setcookie('unbooked_seats', $unbooked_seats, time() + (10800), '/');

    header("Location: ../homepage.php");
} else {
    $feedback = "No rides found for the selected route and time";
    header("Location: ../homepage.php?message=" . urlencode($feedback));
}
$conn->close();
?>
