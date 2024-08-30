<?php 
session_start();
include 'connect.php';
if(isset($_SESSION['mysession'])){
    $myemail = $_SESSION['mysession'];

    include '../../php/connect.php';
    $sql = "SELECT * FROM customer WHERE Cust_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $myemail);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $username = isset($row) && array_key_exists('Cust_name', $row) ? htmlspecialchars($row['Cust_name']) : '';
    $email = isset($row) && array_key_exists('Cust_email', $row) ? htmlspecialchars($row['Cust_email']) : '';
    $phone = isset($row) && array_key_exists('Cust_phone', $row) ? htmlspecialchars($row['Cust_phone']) : '';
    $image = isset($row) && array_key_exists('Cust_image', $row) ? htmlspecialchars($row['Cust_image']) : '';

}
else{
    header('Location: index.php');
}
?>