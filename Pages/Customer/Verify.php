<?php
    include '../../php/sessions.php';
    if($row['Cust_status'] == 'verified') {
        $feedback = "Welcome!";
        header('Location: homepage.php?message=' . $feedback);
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emat | Home</title>
    <link rel="stylesheet" href="../../css/homepage.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <img src="Images/<?php echo $row['Cust_image']?>" alt="profile">
        <h2><?php echo $row['Cust_name']?></h2>
        <p onclick="window.location.href='homepage.php'" id="homeicon"><span class="material-symbols-outlined">home</span>Book</p>
        <p onclick="changeTabs('report')" id="historyicon"><span class="material-symbols-outlined">history</span>Ride History</p>
        <p onclick="changeTabs('feedback')" id="reporticon"><span class="material-symbols-outlined">flag</span>Feedback</p>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <p onclick="changeTabs('settings')" id="settingsicon"><span class="material-symbols-outlined">logout</span>Log Out</p>
    </nav> 
    <div class='verification' style="display: <?php echo $row['Cust_status'] == 'verified' ? 'none' : 'flex'; ?>;">
        <form action='../../php/verify.php' method="post">
            <h1>Verify Your Account</h1>
            <?php
            if(isset($_GET['message'])) {
                $received_message = htmlspecialchars($_GET['message']);
                echo "<p>$received_message</p>";
            } else {
                echo "<p>Please check your email for a verification code.</p>";
            }
            ?>
            <input type='text' name='vericode' id='code' placeholder='Enter Verification Code'>
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['mysession']); ?>">
            <button type="submit">Verify Account</button>
        </form>
    </div>  
    <?php
        if (isset($_GET['message'])) {
            $feedback = urldecode($_GET['message']);
            $animationstyle = "animation: slideleft 3s linear forwards";
            echo "<div class='error' style='".$animationstyle."'>";
            echo "<p id='error-message'>" . htmlspecialchars($feedback) . "</p>";
            echo "</div>";
        }
    ?>
</body>
<script src="js/map.js"></script>
</html> 


