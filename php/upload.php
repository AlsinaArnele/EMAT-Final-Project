<?php
include '../../php/sessions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $targetDir = "../../Images/";
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $targetFile = $targetDir . $_SESSION['username'] . '.' . $imageFileType;
    $uploadOk = 1;
    $message = "";

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $message .= "File is not an image. ";
        $uploadOk = 0;
    }

    if (file_exists($targetFile)) {
        $message .= "Sorry, file already exists. ";
        $uploadOk = 0;
    }

    if ($_FILES["image"]["size"] > 500000) {
        $message .= "Sorry, your file is too large. ";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $message .= "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $message .= "The file " . htmlspecialchars($_SESSION['username']) . '.' . $imageFileType . " has been uploaded.";
        } else {
            $message .= "Sorry, there was an error uploading your file.";
        }
    }

    header("Location: ../pages/customer/profile.php?message=" . urlencode($message));
    exit();
}
?>
