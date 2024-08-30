<?php
    require '../vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $session_lifetime = 7200;
    session_set_cookie_params($session_lifetime);
    session_start();
    include 'connect.php';
    
    $name = $_POST['Username'];
    $email = strtolower($_POST['Email']);
    $phone = $_POST['Phone'];
    $password = $_POST['confirm-password'];
    $hashedpass = password_hash($password, PASSWORD_DEFAULT);
    $vericode = rand(1000, 9999);

    // check whether email exists
    $sql = "SELECT Cust_email FROM customer WHERE Cust_email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($existsemail);
    $stmt->fetch();
    $stmt->close();
    if ($existsemail) {
        $feedback = "Email already exists";
        header('Location: ../Pages/customer/signup.php?feedback=' . $feedback);
        exit();}
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'leviskibet2002@gmail.com';
        $mail->Password = 'pkgy elny metj plet';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('leviskibet2002@gmail.com', 'Levis');
        $mail->addAddress($email, $name);
        $mail->Subject = 'Account Verification';
        $mail->Body = 'Hello ' . $name . ', Welcome to EMAT! Your verification code is ' . $vericode . '. Please enter this code to verify your email address.';
        $mail->send();
    
        $stmt1 = $conn->prepare("INSERT INTO customer (Cust_name, Cust_email, Cust_phone, Cust_pass) VALUES (?, ?, ?, ?)");
        $stmt1->bind_param("ssss", $name, $email, $phone, $hashedpass);
        
        if ($stmt1->execute()) {
            $feedback = "New record created successfully";
            
            $stmt2 = $conn->prepare("INSERT INTO customerverification (Cust_email, Cust_code) VALUES (?, ?)");
            $stmt2->bind_param("ss", $email, $vericode);
            $stmt2->execute();
    
            $_SESSION['mysession'] = $email;
            header('Location: ../Pages/customer/homepage.php');
        } else {
            $stmt3 = $conn->prepare("DELETE FROM customer WHERE Cust_email = ?");
            $stmt3->bind_param("s", $email);
            $feedback = "Error, please try again later.";
            header('Location: ../Pages/customer/signup.php?feedback=' . $feedback);
        }
    } catch (Exception $e) {
        $feedback = "Error sending email: {$mail->ErrorInfo}"; // for debugging

        // user-friendly error message
        $feedback = "Connection error, please try again later.";
        header('Location: ../Pages/customer/signup.php?feedback=' . $feedback);
    }
    
?>
