<?
session_start();
include 'connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT userpassword FROM useraccounts WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($hashedPass);
$stmt->fetch();
$stmt->close();
$conn->close();

if (password_verify($password, $hashedPass)) {
    echo "Login successful";
    $_SESSION['mysession'] = $email;
    header("Location: ../homepage.html");
} else {
    echo "Login failed";
    header("Location: ../index.html");
}
?>