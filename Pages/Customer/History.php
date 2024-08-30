<?php
    include '../../php/sessions.php';
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
    <nav id="nav">
        <div class="burger">
            <span class="material-symbols-outlined" onclick="navDisplay()">close</span>
        </div>
        <img src="../../Images/<?php echo $row['Cust_image'] ?>" alt="profile">
        <h2><?php echo $row['Cust_name'] ?></h2>
        <p onclick="window.location.href='homepage.php'"><span class="material-symbols-outlined">home</span>Book</p>
        <p onclick="window.location.href='history.php'" id="historyicon"><span class="material-symbols-outlined">history</span>Ride History</p>
        <p onclick="window.location.href='profile.php'" id="reporticon"><span class="material-symbols-outlined">flag</span>Feedback</p>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <p onclick="changeTabs('settings')" id="settingsicon"><span class="material-symbols-outlined">logout</span>Log Out</p>
    </nav>
    <!-- TABS -->
    <div class="container">
        <div class="container-nav">
            <div class="greetings">
                <h2>Manage Your Account</h2>
            </div>
            <div class="settings">
                <h2 id="timeDisplay"><?php echo date("D, ")?></h2>
                <a href="#"></a>
            </div>
        </div>
        <div class="inner-container">

        <div id="history" class="history">
            <div class="history-nav">
                <h2>Booking History</h2>
                <button>Download</button>
            </div>
            <div class="day">
                <h3>13/12/2023</h3>
                <table>
                    <tr>
                        <th>Seat ID</th>
                        <th>Route</th>
                        <th>Book Date</th>
                        <th>Departure time</th>
                    </tr>
                    <?php
                    include_once '../../php/connect.php';
                    $sql2 = "SELECT * FROM bookings WHERE Cust_email = ?";
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->bind_param('s', $myemail);
                    $stmt2->execute();   
                    $result2 = $stmt2->get_result();
                    while($row2 = $result2->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".htmlspecialchars($row2['SeatID'])."</td>";
                        echo "<td>".htmlspecialchars($row2['Route'])."</td>";
                        echo "<td>".htmlspecialchars($row2['BookingDate'])."</td>";
                        echo "<td>".htmlspecialchars($row2['departure_time'])."</td>";
                        echo "</tr>";
                    }
                    ?> 
                </table>
            </div>
        </div>

        <div id="settings" class="settings">
                <h1>Confirm Log Out</h1>
                <p>Are you sure you want to log out?</p>
                <form class="logout-btn" action="../../php/logout.php" method="POST">
                    <button type="button" onclick="changeTabs('settings')">Cancel</button>
                    <button type="submit">Log Out</button>
                </form>
            </div>
            <div class="map-display" id="map"></div>
                
        <?php
            if (isset($_GET['message'])) {
                $feedback = urldecode($_GET['message']);
                $animationstyle = "animation: slideleft 3s linear forwards";
                echo "<div class='error' style='".$animationstyle."'>";
                echo "<p id='error-message'>" . htmlspecialchars($feedback) . "</p>";
                echo "</div>";
            }
        ?>
        </div>
        
    </div>
</body>
<script src="js/map.js"></script>
</html> 


