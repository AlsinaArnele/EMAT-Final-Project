<?php
session_start();
include 'connect.php';

if(isset($_SESSION['mysession'])) {
    header("Location: ../homepage.php");
}

$email = $_POST['Email'];
$password = $_POST['Password'];

// check whether email exists
$sql = "SELECT Cust_email FROM customer WHERE Cust_email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($existsemail);
$stmt->fetch();
$stmt->close();
if (!$existsemail) {
    $feedback = "Email does not exist";
    header('Location: ../index.php?feedback=' . $feedback);
    exit();
}

$sql = "SELECT Cust_pass FROM customer WHERE Cust_email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($hashedPass);
$stmt->fetch();
$stmt->close();
$conn->close();
 
if (password_verify($password, $hashedPass)) { 
    $_SESSION['mysession'] = $email;
    header("Location: ../homepage.php");
}
else {
    $feedback = "Invalid password or email!";
    header('Location: ../index.php?feedback=' . $feedback);
}
?>