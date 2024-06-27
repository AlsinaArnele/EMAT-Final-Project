<?php
session_start();
include 'php/book.php';
if(isset($_SESSION['mysession'])){
    $myemail = $_SESSION['mysession'];

    include 'php/connect.php';
    $sql = "SELECT * FROM customer WHERE Cust_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $myemail);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $username = isset($row) && array_key_exists('Cust_name', $row) ? htmlspecialchars($row['Cust_name']) : '';
    $email = isset($row) && array_key_exists('Cust_email', $row) ? htmlspecialchars($row['Cust_email']) : '';
    $phone = isset($row) && array_key_exists('Cust_phone', $row) ? htmlspecialchars($row['Cust_phone']) : '';
    $image = isset($row) && array_key_exists('Cust_image', $row) ? htmlspecialchars($row['Cust_image']) : '';

}
else{
    header('Location: index.php');
}
if(isset($_GET['seats'])){
    $bottomDisplay = "flex";
}
else{
    $bottomDisplay = "none";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emat | Home</title>
    <link rel="stylesheet" href="css/homepage.css">
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
        <p onclick="changeTabs('home')" id="homeicon"><span class="material-symbols-outlined">home</span>Home</p>
        <p onclick="changeTabs('profile')" id="profileicon"><span class="material-symbols-outlined">person</span>Profile</p>
        <p onclick="changeTabs('history')" id="historyicon"><span class="material-symbols-outlined">history</span>Ride History</p>
        <p onclick="changeTabs('report')" id="reporticon"><span class="material-symbols-outlined">flag</span>Feedback Report</p>
        <p></p>
        <p></p>
        <p></p>
        <p onclick="changeTabs('settings')" id="settingsicon"><span class="material-symbols-outlined">logout</span>Log Out</p>
    </nav> 

    <!-- TABS -->
    <div id="home" class="home">
    <form class="top" action="php/fetch.php" method="post">
        <div class="top-details">
            <h1>Make a booking</h1>
            <select name="route" id="route">
                <option value="default-route" selected>Choose Route</option>
                <option value="Rongai">Rongai</option>
                <option value="CBD">Downtown</option>
                <option value="Karen">Karen</option>
                <option value="Ngong">Ngong'</option>
            </select>
            <select name="time" id="time">
                <option value="default-time" selected>Choose Time</option>
                <option value="11">11.30 am</option>
                <option value="2">2.30 pm</option>
                <option value="5">5.30 pm</option>
            </select>
            <div class="buttonss">
                <button type="submit">Confirm Ride</button>
                <button type="reset">Cancel Ride</button>
            </div>
        </div>
    </form>
    <form class="bottom" action="seats.php" method="post" style="display:<?php echo $bottomDisplay?>;">
        <div class="bottom-details">
            <h2>Vehicle Details</h2>
            <input type="text" name="make" id="make" readonly value="Scania">
            <input type="text" name="model" id="model" readonly value="F250">
            <input type="text" name="number" id="numberplate" readonly value="KCD 452K">
            <input type="text" name="driver" id="driver" readonly value="Mr. Edgar Obare">
            <div class="seats">
                <select name="row" id="seatrow" required>
                    <!--php
                    for($i=0; $i<count($selectrows); $i++) {
                        for($j=0; $j<count($selectcols); $j++) {
                            if(!in_array($selectrows[$i].$selectcols[$j], $seatsArray)) {
                                echo "<option value='".$selectrows[$i]."'></option>";
                            } else {
                                echo '<option value="default" selected>Row</option>';
                            }
                        }
                    }
                    !-->
                </select>
                <select name="col" id="seatcol" required>
                    <!--php 
                    for($i=0; $i<count($selectrows); $i++) {
                        for($j=0; $j<count($selectcols); $j++) {
                            if(!in_array($selectrows[$i].$selectcols[$j], $seatsArray)) {
                                echo "<option value='".$selectcols[$j]."'></option>";
                            } else {
                                echo '<option value="default" selected>Row</option>';
                            }
                        }
                    }
                    -->
                </select>
            </div>
        </div>
        <div class="buttonss">
            <button type="submit">Confirm Ride</button>
            <button type="reset">Cancel Ride</button>
        </div>
    </form>
    </div>

    
    <!-- PHP Code for Verification and Profile Details -->
    

    <div class='verification' style="display: <?php echo $row['Cust_status'] == 'verified' ? 'none' : 'flex'; ?>;">
        <form action='php/verify.php' method="post">
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


    <form id="profile" class="profile" method="POST" action="php/update-profile.php">
        <div class="profile-details">
            <h2>Account Details</h2>
            <h3>Username</h3>
            <input type="text" value="<?php echo $username; ?>" id="username" name="Username" required>
            <h3>Email</h3>
            <input type="email" value="<?php echo $email; ?>" id="email" name="Email" required>
            <h3>Phone</h3>
            <input type="tel" value="<?php echo $phone; ?>" id="phone" name="Phone" required>
            <h3>Password</h3>
            <input type="password" name="Password" id="password" placeholder="**********">
        </div>
        <div class="profile-image">
            <h2>Profile Photo</h2>
            <img src="<?php echo "Images/".$image; ?>" id="displayProfile" alt="profile">
            <select name="image" id="profilePhoto">
                <option value="default">Choose Image</option>
                <option value="Mysterious.jpg">Profile 1</option>
                <option value="Neutral.jpg">Profile 2</option>
                <option value="Shocked.jpg">Profile 3</option>
                <option value="Sad.jpg">Profile 4</option>
            </select>
        </div>
        <div class="mybutton">
            <button type="submit">UPDATE</button>
        </div>
    </form>

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
                $sql2 = "SELECT * FROM bookings WHERE Cust_email = ?";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param('s', $myemail);
                $stmt2->execute();   
                $result2 = $stmt2->get_result();
                while($row2 = $result2->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($row2['Driver_name'])."</td>";
                    echo "<td>".htmlspecialchars($row2['Time'])."</td>";
                    echo "<td>".htmlspecialchars($row2['Vehicle_make']." ".$row2['Vehicle_model'])."</td>";
                    echo "<td>".htmlspecialchars($row2['Seat'])."</td>";
                    echo "<td>".htmlspecialchars($row2['Route'])."</td>";
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

    <?php
    if($row['Cust_status'] == 'verified'){
        echo '<script>if (usernameInput.value === "" || emailInput.value === "" || phoneInput.value === "") {alert("Please Update your Profile");changeTabs("profile");}</script>';
    }
    ?>
</body>
<script src="js/map.js"></script>
<script>
    routeSelect.addEventListener('change', setTrack);
    timeSelect.addEventListener('change', setTrack);
</script>
</html> 
