<?php
session_start();
include 'connect.php';

if(isset($_SESSION['driver'])) {
    header("Location: ../driver.php");
}

$id = $_POST['driverid'];
$password = $_POST['Password'];

// check whether id exists
$sql = "SELECT Driver_id FROM customer WHERE Driver_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->bind_result($existsemail);
$stmt->fetch();
$stmt->close();
if (!$existsemail) {
    $feedback = "Invalid ID!";
    header('Location: ../driver.php?feedback=' . $feedback);
    exit();
}

$sql = "SELECT Driver_password FROM customer WHERE Driver_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->bind_result($hashedPass);
$stmt->fetch();
$stmt->close();
$conn->close();
 
if (password_verify($password, $hashedPass)) { 
    $_SESSION['driver'] = $id;
    header("Location: ../driver.php");
}
else {
    $feedback = "Invalid password or email!";
    header('Location: ../driver.php?feedback=' . $feedback);
}
?>