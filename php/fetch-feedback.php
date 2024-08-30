<?php
include 'admin-session.php';
include 'connect.php';

$records_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

$filter = isset($_GET['feedback-filter']) ? $_GET['feedback-filter'] : 'rating';
$ascending = isset($_GET['feedback-ascending-filter']) ? $_GET['feedback-ascending-filter'] : 'ASC';

$sql = $conn->prepare("SELECT * FROM feedback ORDER BY $filter $ascending LIMIT ?, ?");
$sql->bind_param("ii", $offset, $records_per_page);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $student_id = $row["student_id"];
        $sql2 = $conn->prepare("SELECT * FROM customer WHERE Cust_id = ?");
        $sql2->bind_param("i", $student_id);
        $sql2->execute();
        $result2 = $sql2->get_result();

        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();

            echo '<tr class="tr">';
                echo '<td class="profile-image">' . htmlspecialchars($row["feedback_id"]) . '</td>';
                echo '<td class="username">' . htmlspecialchars($row["rating"]) . '</td>';
                echo '<td class="email">' . htmlspecialchars($row["comment"]) . '</td>';
                echo '<td class="status" id="user-data">' . htmlspecialchars($row2["Cust_email"]) . '</td>';
                echo '<td class="actions">
                        <button onclick="toggleStatus(\'' . htmlspecialchars($row["feedback_id"]) . '\')"><span class="material-icons">lock</span></button>
                        <button onclick="deleteRow(\'' . htmlspecialchars($row["feedback_id"]) . '\', \'tickets\')"><span class="material-icons">delete</span></button>
                      </td>';
            echo '</tr>';
        } else {
            echo "<tr class='tr'><td colspan='6'>Customer data not found for feedback ID: " . htmlspecialchars($row["feedback_id"]) . "</td></tr>";
        }
    }
} else {
    echo "<tr class='tr'><td colspan='6'>No data found</td></tr>";
}

// $conn->close();
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

