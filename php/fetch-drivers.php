<?php
include 'admin-session.php';
include 'connect.php';

$records_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

$search = isset($_GET['drivers_search']) ? $_GET['drivers_search'] : '';
$filter = isset($_GET['drivers-filter']) ? $_GET['drivers-filter'] : 'Driver_name';
$ascending = isset($_GET['users-ascending-filter']) ? $_GET['users-ascending-filter'] : 'ASC';

if (!empty($search)) {
    $sql = "SELECT * FROM drivers WHERE Driver_name LIKE '%$search%' OR Driver_email LIKE '%$search%' ORDER BY $filter $ascending LIMIT $offset, $records_per_page";
} else {
    $sql = "SELECT * FROM drivers ORDER BY $filter $ascending LIMIT $offset, $records_per_page";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr class="tr">';
            echo '<td class="profile-image">' . '<img src="../../Images/' . $row["Driver_url"] . '">' . '</td>';
            echo '<td class="username">' . $row["Driver_name"] . '</td>';
            echo '<td class="email">' . $row["Driver_email"] . '</td>';
            echo '<td class="status" id="user-data">' . $row["Driver_status"] . '</td>';
            echo '<td class="actions">
                    <button onclick="toggleStatus(\'' . $row["Driver_email"] . '\')"><span class="material-icons">lock</span></button>
                    <button onclick="deleteRow(\'' . $row["Driver_email"] . '\', \'drivers\')"><span class="material-icons">delete</span></button>
                  </td>';
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