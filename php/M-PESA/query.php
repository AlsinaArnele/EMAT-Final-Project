<?php
session_start();
require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../connect.php';

if (isset($_GET['checkoutRequestID'])) {
    $checkoutRequestID = $_GET['checkoutRequestID'];

    ob_start();
    include 'token.php';
    $accessToken = ob_get_clean();

    $retryCount = 5;
    $retryInterval = 10;
    $paymentStatusUpdated = false;

    while ($retryCount > 0 && !$paymentStatusUpdated) {
        $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query');

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);

        $shortCode = '174379';
        $timestamp = date('YmdHis');
        $passKey = ''; // Sandbox Pass Key
        $password = base64_encode($shortCode . $passKey . $timestamp);

        $requestBody = json_encode([
            "BusinessShortCode" => $shortCode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "CheckoutRequestID" => $checkoutRequestID
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo "Failed to query payment status. Retrying...";
            $retryCount--;
            sleep($retryInterval);
            continue;
        }

        $responseDecoded = json_decode($response, true);

        if (isset($responseDecoded['ResultCode']) && $responseDecoded['ResultCode'] == 0) {
            $paymentStatusUpdated = true;
            $bookingStatus = "confirmed";
            $route = $_SESSION['route'];
            $seat = $_SESSION['seatID'];
            $time = $_SESSION['time'];
            $email = $_SESSION['mysession'];

            $sql = "INSERT INTO bookings (Cust_email, SeatID, Route, booking_status, departure_time) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $email, $seat, $route, $bookingStatus, $time);
            $stmt->execute();

            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = '';
                $mail->Password = '';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('', '');
                $mail->addAddress($email);
                $mail->Subject = 'Payment Confirmation';
                $mail->Body = 'Dear Customer, Your payment was successful. Your booking for route ' . $route . ' with seat number ' . $seat . ' is confirmed for departure at ' . $time . '.';
                $mail->send();

            } catch (Exception $e) {
                echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            $feedback = "Payment was successful";
            $_SESSION['bookingStatus'] = $bookingStatus;
            header('Location: ../../pages/customer/homepage.php?message=' . urlencode($feedback));
            exit();
        }

        $retryCount--;
        sleep($retryInterval);
    }

    if (!$paymentStatusUpdated) {
        $feedback = "Payment was not successful";
        header('Location: ../../pages/customer/homepage.php?message=' . urlencode($feedback));
    }

} else {
    echo "CheckoutRequestID not provided";
}
