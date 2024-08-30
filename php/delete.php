<?php
include 'connect.php';

if (isset($_POST['email']) && isset($_POST['table'])) {
    $email = $_POST['email'];
    $table = $_POST['table'];
    // list of allowed tables
    $allowedTables = ['customer', 'drivers', 'feedback'];

    if (in_array($table, $allowedTables)) {
        if ($table === 'customer') {
            $sql = "DELETE FROM customer WHERE Cust_email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                echo "Entry deleted successfully.";
            } else {
                echo "Error deleting entry.";
            }
        } else if ($table === 'drivers') {
            $sql = "DELETE FROM drivers WHERE Driver_email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                echo "Entry deleted successfully.";
            } else {
                echo "Error deleting entry.";
            }
        } else if ($table === 'feedback') {
            $sql = "DELETE FROM feedback WHERE feedback_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $email);
            if ($stmt->execute()) {
                echo "Entry deleted successfully.";
            } else {
                echo "Error deleting entry.";
            }
        }
    } else {
        echo "Invalid table specified.";
    }
}
