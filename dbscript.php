<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ematbooking";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO seats (SeatID, BusID, SeatRow, SeatColumn) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiii", $seatID, $busID, $seatRow, $seatColumn);

$busID = 187;
$seatID = 41;

for ($row = 1; $row <= 5; $row++) {
    for ($col = 1; $col <= 4; $col++) {
        $seatRow = $row;
        $seatColumn = $col;
        $stmt->execute();
        $seatID++;
    }
}

$stmt->close();
$conn->close();

echo "Twenty entries inserted successfully.";
?>
