<?php
include 'admin-session.php';
include 'connect.php';

$records_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['users-filter']) ? $_GET['users-filter'] : 'Cust_name';
$ascending = isset($_GET['users-ascending-filter']) ? $_GET['users-ascending-filter'] : 'ASC';

if (!empty($search)) {
    $sql = "SELECT * FROM customer WHERE Cust_name LIKE '%$search%' OR Cust_email LIKE '%$search%' ORDER BY $filter $ascending LIMIT $offset, $records_per_page";
} else {
    $sql = "SELECT * FROM customer ORDER BY $filter $ascending LIMIT $offset, $records_per_page";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr class="tr">';
            echo '<td class="profile-image">' . '<img src="../../Images/' . $row["Cust_image"] . '">' . '</td>';
            echo '<td class="username">' . $row["Cust_name"] . '</td>';
            echo '<td class="email">' . $row["Cust_email"] . '</td>';
            echo '<td class="status" id="user-data">' . $row["Cust_status"] . '</td>';
            echo '<td class="actions">
                    <button onclick="toggleStatus(\'' . $row["Cust_email"] . '\')"><span class="material-icons">lock</span></button>
                    <button onclick="deleteRow(\'' . $row["Cust_email"] . '\', \'customer\')"><span class="material-icons">delete</span></button>
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