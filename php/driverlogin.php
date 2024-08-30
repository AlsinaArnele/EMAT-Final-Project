<?php
session_start();
include 'connect.php';

if(isset($_SESSION['driver'])) {
    header("Location: ../pages/driver/driver.php");
}

$id = $_POST['driverid'];
$password = $_POST['password'];

// check whether id exists
$sql = "SELECT driver_id FROM drivers WHERE driver_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->bind_result($existsemail);
$stmt->fetch();
$stmt->close();
if (!$existsemail) {
    $feedback = "Invalid ID!";
    header('Location: ../pages/driver/driver.php?feedback=' . $feedback);
    exit();
}

$sql = "SELECT Driver_password FROM drivers WHERE Driver_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->bind_result($hashedPass);
$stmt->fetch();
$stmt->close();
$conn->close();
 
if (password_verify($password, $hashedPass)) { 
    $_SESSION['driver'] = $id;
    $feedback = "Welcome!";
    header('Location: ../pages/driver/driver.php?feedback=' . $feedback);
}
else if($password == $hashedPass){
    $_SESSION['driver'] = $id;
    $feedback = "Welcome!";
    header('Location: ../pages/driver/driver.php?feedback=' . $feedback);
}
else {
    $feedback = "Invalid password or ID!";
    header('Location: ../pages/driver/driver.php?feedback=' . $feedback);
}
?>