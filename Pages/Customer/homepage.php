<?php
include '../../php/sessions.php';

if (isset($_SESSION['seats'])) {
    $available_seats = $_SESSION['seats'];
} else {
    $available_seats = [];
}
if (isset($_SESSION['route'])) {
    $routedisplay = "display: flex;";
    $selectdisplay = "display: none;";
    $route = $_SESSION['route'];
    if (isset($_SESSION['time'])) {
        $timedisplay = "display: flex;";
        $time = $_SESSION['time'];

        $routeElement = '<input type="hidden" name="routeTrack" id="route" value="' . $route . '" readonly>';
        $timeElement = '<input type="hidden" name="timeTrack" id="time" value="' . $time . '" readonly>';
    } else {
        $timedisplay = "display: none;";
        $time = "";

        $routeElement = '<input type="hidden" name="routeTrack" id="route" value="' . $route . '" readonly>';
        $timeElement = "";
    }
} else {
    $routedisplay = "display: none;";
    $selectdisplay = "display: flex;";
    $route = "";
    $routeElement = "";
    $timedisplay = "display: none;";
    $time = "";
    $timeElement = "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emat | Home</title>
    <link rel="stylesheet" href="../../css/homepage.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
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
        <p onclick="changeTabs('home')" id="homeicon"><span class="material-symbols-outlined">home</span>Book</p>
        <p onclick="window.location.href='history.php'" id="historyicon"><span class="material-symbols-outlined">history</span>Ride History</p>
        <p onclick="window.location.href='profile.php'" id="reporticon"><span class="material-symbols-outlined">flag</span>Feedback</p>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <p onclick="changeTabs('settings')" id="settingsicon"><span class="material-symbols-outlined">logout</span>Log Out</p>
    </nav>
    <?php
    if (isset($_GET['message'])) {
        $feedback = urldecode($_GET['message']);
        $animationstyle = "animation: slidedown 3s linear forwards";
        echo "<div class='error' style='" . $animationstyle . "'>";
        echo "<p id='error-message'>" . htmlspecialchars($feedback) . "</p>";
        echo "</div>";
    }
    ?>
    <!-- TABS -->
    <div class="container">
        <div class="container-nav">
            <div class="greetings">
                <h2>Good Day, <?php echo $row['Cust_name']; ?></h2>
            </div>
            <div class="settings">
                <span class="material-symbols-outlined" onclick="navDisplay()">menu</span>
                <h2 id="timeDisplay"><?php echo date("D, H:I A") ?></h2>
                <span onclick="window.location.href='profile.php'" class="material-symbols-outlined">settings</span>
            </div>
        </div>
        <?php
        echo $routeElement;
        echo $timeElement;
        ?>

        <div class="inner-container">
            <?php
            include '../../php/connect.php';

            $bookingstatus = 'confirmed';
            $sql = "SELECT * FROM bookings WHERE Cust_email = ? AND Booking_status=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $_SESSION['mysession'], $bookingstatus);
            $stmt->execute();
            $result = $stmt->get_result();
            $row2 = $result->fetch_assoc();
            $stmt->close();

            if ($result->num_rows > 0) {
                $homedisplay = "display: none;";
                $ticketdisplay = "display: flex;";
            } else {
                $homedisplay = "display: flex;";
                $ticketdisplay = "display: none;";
            }

            // Fetch seat information from the seats table
            $sql = "SELECT seatColumn, seatRow FROM seats WHERE SeatID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $row2['SeatID']);
            $stmt->execute();
            $result = $stmt->get_result();
            $seat = $result->fetch_assoc();
            $stmt->close();

            if ($seat) {
                $seatColumn = $seat['seatColumn'];
                $seatRow = $seat['seatRow'];

                // Convert seatColumn number to corresponding letter
                switch ($seatColumn) {
                    case 1:
                        $seatColumn = "A";
                        break;
                    case 2:
                        $seatColumn = "B";
                        break;
                    case 3:
                        $seatColumn = "C";
                        break;
                    case 4:
                        $seatColumn = "D";
                        break;
                    default:
                        $seatColumn = "Unknown";
                        break;
                }

            }

            ?>

            <div id="home" class="home" style="<?php echo $homedisplay; ?>">
                <form action="../../php/fetch.php" method="post">
                    <h1>Make a booking</h1>
                    <select name="myroute" id="route" style="<?php echo $selectdisplay ?>;">
                        <option value="default-route" selected>Choose Route</option>
                        <option value="991">Ongata Rongai</option>
                        <option value="989">Downtown Nairobi</option>
                        <option value="Karen" disabled>Karen</option>
                        <option value="990">Ngong'</option>
                    </select>
                    <select name="mytime" id="time" style="<?php echo $selectdisplay ?>;">
                        <option value="default-time" selected>Choose Time</option>
                        <option value="morning">11.30 am</option>
                        <option value="afternoon">2.30 pm</option>
                        <option value="evening">5.30 pm</option>
                    </select>
                    <input type="text" name="route" id="sessionroute" style="<?php echo $routedisplay; ?>" value="<?php echo $route; ?>" readonly>
                    <input type="text" name="time" id="time" style="<?php echo $timedisplay; ?>" value="<?php echo $time; ?>" readonly>
                    <div class="buttonss" style="<?php echo $selectdisplay ?>;">
                        <button type="submit">Confirm Ride</button>
                        <button type="reset">Cancel Ride</button>
                    </div>
                </form>
                <?php if (!empty($available_seats)): ?>
                    <form action="../../php/M-PESA/payment.php" method="post">
                        <h1>Select seat</h1>
                        <select name="seatnumber" id="seat">
                            <option value="default" selected>Choose a seat</option>
                            <?php foreach ($available_seats as $seat): ?>
                                <option value="<?php echo htmlspecialchars($seat); ?>"><?php echo htmlspecialchars($seat); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <Button type="submit">Book Ride</Button>
                        <button type="button" onclick="clearRoute()">Cancel Ride</button>
                    </form>
                <?php endif; ?>
            </div>

            <div class="ticket" style="<?php echo $ticketdisplay; ?>">
                <h1>Your Ride Details</h1>
                <div type="text" name="route" id="ticketroute" value="" ><?php echo $row2['Route']; ?></div>
                <div type="text" name="time" id="time" ><?php echo $row2['BookingDate']; ?></div>
                <div type="text" name="seat" id="seat"  ><?php echo $seatRow . " " . $seatColumn; ?></div>
                <div type="text" name="price" id="price" value="Total paid: " >Sh. 50</div>
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
        </div>

    </div>
</body>
<script src="../../js/map.js"></script>

</html>