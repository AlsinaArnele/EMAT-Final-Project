<?php
include 'php/connect.php';
    session_start();
    if (!isset($_SESSION['driver'])) {
        $style = "style='display: flex;'";
    }else{
        $style = "style='display: none;'";
        $sql = 'SELECT * FROM `drivers` WHERE `driver_id` = ?';
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param('s', $_SESSION['driver']);
        $stmt -> execute();
        $result = $stmt -> get_result();
        $row = $result -> fetch_assoc();

        $sql2 = 'SELECT * FROM `buses` WHERE `driver_id` = ?';
        $stmt2 = $conn -> prepare($sql2);
        $stmt2 -> bind_param('s', $_SESSION['driver']);
        $stmt2 -> execute();
        $result2 = $stmt2 -> get_result();
        $row2 = $result2 -> fetch_assoc();
        $route = $row2['Route_name'];

        $sql3 = 'SELECT * FROM `routes` WHERE `Route_name` = ?';
        $stmt3 = $conn -> prepare($sql3);
        $stmt3 -> bind_param('s', $route);
        $stmt3 -> execute();
        $result3 = $stmt3 -> get_result();
        $row3 = $result3 -> fetch_assoc();
    }

    date_default_timezone_set('Africa/Nairobi');
$current_time = date('H:i');

$schedule_times = [
    '11:30',
    '14:30',
    '17:30'
];

$departure_schedule = null;
foreach ($schedule_times as $time) {
    if ($current_time < $time) {
        $departure_schedule = $time;
        break;
    }
}

if ($departure_schedule === null) {
    $feedback = "No available schedule times.";
    header("Location: ../Driver.php?feedback=".$feedback);
    exit();
}

$arrivaltime = date('H:i', strtotime($departure_schedule . ' +1 hour'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emat | Home</title>
    <link rel="stylesheet" href="css/driver.css">
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

<!-- Add check in functionality -->
    <nav>
        <form action="php/driverlogout.php" style="display: none;" id="logout"></form>
        <h1>EMAT</h1> 
        <img src="Images/Driver.jpg" alt="Driver">
        <h2><?php echo $row['Driver_name']?></h2>
        <p onclick="changeTabs('home')" id="homeicon"><span class="material-symbols-outlined">home</span>Home</p>
        <p onclick="changeTabs('history')" id="historyicon"><span class="material-symbols-outlined">history</span>Ride History</p>
        <p onclick="changeTabs('report')" id="reporticon"><span class="material-symbols-outlined">flag</span>Report Issue</p>
        <p onclick="logout()" id="settingsicon"><span class="material-symbols-outlined">logout</span>Log Out</p>
    </nav>

     <div class="logincontainer" <?php echo $style?>>
            <form class="loginform" action="php/driverlogin.php" method="POST">
                <h1>Hello, kindly check in.</h1>
                <div class="textbox">
                    <h2>Driver ID</h2>
                    <input type="text" name="driverid" required>
                </div>
                <div class="textbox">
                    <h2>Driver Password</h2>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Log In</button>
                <p>Forgot password? <a href="">Contact admin.</a></p>
            </form> 
     </div>
    
    <div id="home" class="home">
        <div class="mininav">
            <div class="mini">
                <h5><?php echo $row['Driver_name']?></h5>
                <span class="material-symbols-outlined" onclick="profile()">settings</span>
            </div>
            <div class="lineHori"></div>
        </div>
        <form id="profile">
            <div class="inputs">
                <h2>Employee Name</h2>
                <input type="text" value="<?php echo $row['Driver_name']?>" readonly>
            </div>
            <div class="inputs">
                <h2>Employee Password</h2>
                <input type="password" placeholder="**********" >
            </div>
            <button>Update Details</button>
        </form>
        <div class="scheduling">
            <h5>Default Route</h5>
            <div class="inputs">
                <h2>Start</h2>
                <input type="text" value="<?php echo $row3['start_location']?>" readonly>
            </div>
            <div class="inputs">
                <h2>Destination</h2>
                <input type="text" value="<?php echo $row3['end_location']?>" readonly>
            </div>
            <div class="double">
                <div class="inputs">
                    <h2>Next Departure</h2>
                    <input type="text" value="<?php echo $departure_schedule?>" readonly>
                </div>
                <div class="inputs">
                    <h2>Expected Arrival</h2>
                    <input type="text" value="<?php echo $arrivaltime?>" readonly>
                </div>
            </div>
            
            <form action="php/createride.php" method="post">
                <input type="hidden" name="busid" value="<?php echo $row2['BusID']?>">
                <input type="hidden" name="routeid" value="<?php echo $row3['Route_ID']?>">
                <?php
                    $sql = "SELECT *FROM schedules WHERE BusID = ? AND Schedule_status = 'Scheduled'";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('s', $row2['BusID']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $numrows = $result->num_rows;
                    if ($numrows > 0) {
                        $button = "disabled";
                        $message = "Pending Ride";
                    }else{
                        $button = "";
                        $message = "Schedule Ride";
                    }
                ?>
                <button type="submit" <?php echo $button;?>><?php echo $message;?></button>
            </form>
        </div>
        <div class="details">
            <div class="inputs">
                <h2>Number Plate</h2>
                <input type="text" value="<?php echo $row2['BusNumber']?>" readonly>
            </div>
            <div class="inputs">
                <h2>Bus Capacity</h2>
                <input type="text" value="<?php echo $row2['TotalSeats']?> Passengers" readonly>
            </div>
            <div class="inputs">
                <h2>Route</h2>
                <input type="text" value="<?php echo $row2['Route_name']?> Route" readonly>
            </div>
        </div>
    </div>

    <div id="history" class="history">
        <div class="history-nav">
            <h2>Booking History</h2>
            <button>Download</button>
        </div>
        <div class="day">
            <h3>13/12/2023</h3>
            <table>
                <tr>
                    <th>Driver</th>
                    <th>Time</th>
                    <th>Vehicle</th>
                    <th>Seat</th>
                    <th>Route</th>
                </tr>
                <?php
                $sql = "SELECT * FROM bookings WHERE Cust_email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $myemail);
                $stmt->execute();   
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($row['Driver_name'])."</td>";
                    echo "<td>".htmlspecialchars($row['Time'])."</td>";
                    echo "<td>".htmlspecialchars($row['Vehicle_make']." ".$row['Vehicle_model'])."</td>";
                    echo "<td>".htmlspecialchars($row['Seat'])."</td>";
                    echo "<td>".htmlspecialchars($row['Route'])."</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <form id="report" class="report">
        <h2>Give Feedback</h2>
        <h2>What is your experience using Emat?</h2>
        <div class="faces">
            <span class="material-symbols-outlined" id="1" onclick="submitFeedback('1')">sentiment_very_dissatisfied</span>
            <span class="material-symbols-outlined" id="2" onclick="submitFeedback('2')">sentiment_dissatisfied</span>
            <span class="material-symbols-outlined" id="3" onclick="submitFeedback('3')">sentiment_neutral</span>
            <span class="material-symbols-outlined" id="4" onclick="submitFeedback('4')">sentiment_satisfied</span>
            <span class="material-symbols-outlined" id="5" onclick="submitFeedback('5')">sentiment_very_satisfied</span>
        </div>
        <h2>What are the reasons for your feedback?</h2>
        <input type="hidden" id="rating-holder" name="rating">
        <textarea name="feedback" id="feedback" cols="30" rows="10"></textarea>
        <div class="consent">
            <input type="checkbox" value="consent" id="consent">
            <label for="consent">I consent to the use of my feedback for improvement purposes</label>
        </div>
        <div class="buttons">
            <button type="submit">Submit Feedback</button>
            <button type="reset">Cancel</button>
        </div>
    </form>
    
    <div id="settings" class="settings">
        <h1>Confirm Log Out</h1>
        <p>Are you sure you want to log out?</p>
        <form class="logout-btn" action="php/logout.php" method="POST">
            <button type="button" onclick="changeTabs('settings')">Cancel</button>
            <button type="submit">Log Out</button>
        </form>
    </div>

    <div class="map-display" id="map"></div>
    <div class='error' >
        <p id='error-message'></p>
        <?php
            if (isset($_GET['message'])) {
                $feedback = urldecode($_GET['message']);
                echo "<p>" . htmlspecialchars($feedback) . "</p>";
            }
        ?>
    </div>
</body>
<script src="js/map.js"></script>
</html>
