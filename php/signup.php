<?php
    session_start();
    include 'connect.php';
    
    $name = $_POST['Username'];
    $email = $_POST['Email'];
    $password = $_POST['confirm-password'];

    $sql = "INSERT INTO customer (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        $_SESSION['mysession'] = $email;
        header('Location: ../homepage.html');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>