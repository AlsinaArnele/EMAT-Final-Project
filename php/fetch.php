<?php
session_start();
include 'connect.php';

$route = intval($_POST['myroute']);
$time_label = $_POST['mytime'];

if ($time_label == "morning") {
    $time = date("Y-m-d") . ' 11:30:00';
} elseif ($time_label == "afternoon") {
    $time = date("Y-m-d") . ' 14:30:00';
} elseif ($time_label == "evening") {
    $time = date("Y-m-d") . ' 17:30:00';
} else {
    $feedback = "Please select a valid time";
    // header("Location: ../pages/customer/homepage.php?message=" . urlencode($feedback));
    echo $feedback;
    echo "<br>";
    echo $route;
    echo "<br>";
    echo $time;
    exit();
}

$sql = "SELECT * FROM schedules WHERE Route_ID = ? AND departure_time = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $route, $time);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $all_seats = [];
    $columns_labels = range('A', 'D');
    $columns = count($columns_labels);

    for ($i = 1; $i <= 7; $i++) {
        for ($j = 0; $j < $columns; $j++) {
            $all_seats[] = $i . $columns_labels[$j];
        }
    }

    $booked_seats = [];
    $sql = "SELECT seatID FROM bookings WHERE `Route` = ? AND departure_time = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $route, $time);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $booked_seats[] = $row['seatID'];
    }

    $unbooked_seats = array_diff($all_seats, $booked_seats);

    $sql3 = "SELECT Route_name FROM routes WHERE Route_ID = ?";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("i", $route);
    $stmt3->execute();
    $result3 = $stmt3->get_result();
    $row3 = $result3->fetch_assoc();

    $_SESSION['time'] = $time;
    $_SESSION['route'] = $row3['Route_name'];
    $_SESSION['seats'] = $unbooked_seats;

    $feedback = "Please select your seat";
    header("Location: ../pages/customer/homepage.php?message=" . urlencode($feedback));
    exit();
} else {
    $feedback = "No rides found for the selected route and time";
    header("Location: ../pages/customer/homepage.php?message=" . urlencode($feedback));
    exit();
}

$conn->close();
?>
