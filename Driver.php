<?php
include 'php/connect.php';
    session_start();
    if (!isset($_SESSION['driver'])) {
        $style = "style='display: flex;'";
    }else{
        $style = "style='display: none;'";
        $sql = 'SELECT * FROM `driver` WHERE `id` = ?';
        $stmt = $conn -> prepare($sql);
        $stmt -> bind_param('s', $_SESSION['driver']);
        $stmt -> execute();
        $result = $stmt -> get_result();
        $row = $result -> fetch_assoc();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emat | Home</title>
    <link rel="stylesheet" href="css/driver.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>

<!-- Add check in functionality -->
    <nav>
        <p onclick="changeTabs('home')" id="homeicon"><span class="material-symbols-outlined">home</span></p>
        <p onclick="changeTabs('history')" id="historyicon"><span class="material-symbols-outlined">history</span></p>
        <p onclick="changeTabs('history')" id="historyicon"><span class="material-symbols-outlined">comment</span></p>
    </nav>

     <div class="logincontainer" <?php echo $style?>
            <form class="loginform" action="Driverlogin.php">
                <h1>Hello, kindly check in.</h1>
                <div class="textbox">
                    <h2>Driver ID</h2>
                    <input type="text" name="id" required>
                </div>
                <div class="textbox">
                    <h2>Driver Password</h2>
                    <input type="text" name="id" required>
                </div>
                <button type="submit">Log In</button>
            </form> 
     </div>
    
    <div id="home" class="home">
        <div class="top">
            <h1>Schedule New Ride</h1>
            <p>Next ride is at <span id="UpdateTime">:</span>.</p>
            <div class="submit" id="submitNew" onclick="submitNew()">
                <div class="availablecard">Schedule</div>
                <div class="unavailablecard">Unavailable</div>
            </div>

            <div class="busDetails">
                <!-- <img src="" alt=""> -->
                <div class="info">
                    <h2>Designated Driver:</h2>
                    <p>John Doe</p>
                </div>
                <div class="info">
                    <h2>Backup Driver:</h2>
                    <p>John Doe</p>
                </div>
                <div class="info">
                    <h2>Bus Number:</h2>
                    <p>1234</p>
                </div>  
                <div class="info">
                    <h2>Route</h2>
                    <p>Ngong'</p>
                </div>
            </div>
        </div>
        <div class="line"></div>
        <div class="right">

        </div>
        <div class="line"></div>
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
                    include 'php/connect.php';
                    ?>
                </table>
            </div>
        </div>
    </div>
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
<script src="js/driver.js"></script>

</html>
