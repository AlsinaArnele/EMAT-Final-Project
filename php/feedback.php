 <?php 
    include 'connect.php';
    $rating = $_POST["rating"];
    $feedback = $_POST["feedback"];
    $email = $_POST['email'];

    $sql = "SELECT * FROM customer WHERE Cust_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $id = $row['Cust_id'];

    $sql = "INSERT INTO feedback (Student_id, rating, comment) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $id, $rating, $feedback);
    $stmt->execute();
    $stmt->close();

    $feedback = "Thank you for your feedback!";
    header("Location: ../homepage.php?feedback=".$feedback);

 ?>