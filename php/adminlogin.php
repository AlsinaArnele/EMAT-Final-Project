<?php
session_start();
include 'connect.php';

if(isset($_SESSION['admin'])) {
    header("Location: ../pages/admin/Admin-Accounts.php");
}

$id = $_POST['adminusername'];
$password = $_POST['password'];

$sql = "SELECT Admin_name FROM admins WHERE Admin_name=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->bind_result($existsemail);
$stmt->fetch();
$stmt->close();
if (!$existsemail) {
    $feedback = "Invalid ID!";
    header('Location: ../pages/admin/Admin-Accounts.php?feedback=' . $feedback);
    exit();
}

$sql = "SELECT Admin_password FROM admins WHERE Admin_name=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->bind_result($hashedPass);
$stmt->fetch();
$stmt->close();
$conn->close();
 
if (password_verify($password, $hashedPass)) { 
    $_SESSION['admin'] = $id;
    $feedback = "Welcome!";
    header('Location: ../pages/admin/Admin-Accounts.php?feedback=' . $feedback);
}
else if($password == $hashedPass){
    $_SESSION['admin'] = $id;
    $feedback = "Welcome!";
    header('Location: ../pages/admin/Admin-Accounts.php?feedback=' . $feedback);
}
else {
    $feedback = "Invalid password or ID!";
    header('Location: ../pages/admin/Admin-Accounts.php?feedback=' . $feedback);
}
?>