<?php
include 'admin-session.php';
include 'connect.php';

$records_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

$search = isset($_GET['feedback_search']) ? $_GET['feedback_search'] : '';
$filter = isset($_GET['feedback-filter']) ? $_GET['feedback-filter'] : 'Cust_email';
$ascending = isset($_GET['feedback-ascending-filter']) ? $_GET['feedback-ascending-filter'] : 'ASC';

if (!empty($search)) {
    $sql = "SELECT * FROM bookings WHERE Cust_name LIKE '%$search%' OR Cust_email LIKE '%$search%' ORDER BY $filter $ascending LIMIT $offset, $records_per_page";
} else {
    $sql = "SELECT * FROM bookings ORDER BY $filter $ascending LIMIT $offset, $records_per_page";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sql2 = "SELECT * FROM buses WHERE BusID = " . $row['BusID'];
        $result2 = $conn->query($sql2);
        $bus = $result2->fetch_assoc();

        echo '<tr class="tr">';
            echo '<td class="email">' . $row['Cust_email']. '</td>';
            echo '<td class="username">' . $row["SeatID"] . '</td>';
            echo '<td class="status">' . $bus["BusNumber"] . '</td>';
            echo '<td class="email" id="user-data">' . $row["BookingDate"] . '</td>';
            echo '<td class="status" id="user-data">' . $row["Route"] . '</td>';
            echo '<td class="status" id="user-data">' . $row["Booking_status"] . '</td>';
        echo '</tr>';
    }
} else {
    echo "<tr class='tr'><td colspan='6'>No data found</td></tr>";
}

$conn->close();
?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const statusElements = document.querySelectorAll(".status");

        statusElements.forEach(element => {
            const status = element.innerText.toLowerCase().trim();
            if (status === 'disabled') {
                element.style.color = 'red';
            } else if (status === 'active') {
                element.style.color = 'green';
            }
        });
    });
</script>