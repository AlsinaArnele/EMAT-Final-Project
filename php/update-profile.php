<?php
session_start();
include 'connect.php';

$myemail = $_SESSION['mysession'];
$name = $_POST['Username'];
$email = strtolower($_POST['Email']);
$phone = $_POST['Phone'];
$password = $_POST['Password'];
$image = $_POST['image'];
$hashedpass = password_hash($password, PASSWORD_DEFAULT);

// echo $name ." ".$email." ".$phone;

if ($password == "") {
    $sql = "UPDATE customer SET Cust_name=?, Cust_email=?, Cust_phone=?, Cust_image=? WHERE Cust_email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $phone, $image, $myemail);
    $stmt->execute();
    $stmt->close();
} else {
    $sql = "UPDATE customer SET Cust_name=?, Cust_email=?, Cust_phone=?, Cust_pass=?, Cust_image=? WHERE Cust_email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $email, $phone, $hashedpass, $image, $myemail);
    $stmt->execute();
    $stmt->close();
}
$feedback = "Record updated successfully";
header('Location: ../homepage.php?feedback=' . $feedback);
?>
