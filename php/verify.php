<?php
include 'connect.php';

$code = $_POST['vericode'];
$email = $_POST['email'];

$sql = "SELECT Cust_code FROM customerverification WHERE Cust_email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($savedCode);
$stmt->fetch();
$stmt->close();

if ($code != $savedCode) {
    $mymessage = "Invalid verification code";
    header("Location: ../Pages/Customer/Verify.php?message=" . urlencode($mymessage));
} else {
    $sql = "DELETE FROM customerverification WHERE Cust_email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute(); 
    $stmt->close();

    $verify = "UPDATE customer SET Cust_status='verified' WHERE Cust_email=?";
    $stmt = $conn->prepare($verify);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    $mymessage = "Account verified";
    header("Location: ../Pages/Customer/homepage.php?message=" . urlencode($mymessage));
}
?>