<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['admin'])){
    $myemail = $_SESSION['admin'];
    include 'connect.php';
    $style = "style='display: none;'";
    $sql = "SELECT * FROM admins WHERE Admin_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $myemail);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
}
else{
    $style = "style='display: flex;'";
}
?>