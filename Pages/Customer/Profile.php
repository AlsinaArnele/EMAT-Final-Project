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
        <p onclick="window.location.href='homepage.php'" id="homeicon"><span class="material-symbols-outlined">home</span>Book</p>
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
                <h2 id="timeDisplay"><?php echo date("D, ") ?></h2>
                <span onclick="window.location.href='#'" class="material-symbols-outlined">settings</span>
            </div>
        </div>
        <div class="inner-container">
            <div id="profile" class="profile">
                <form class="profile-details" method="POST" action="php/update-profile.php" enctype="multipart/form-data">
                    <h2>Account Details</h2>
                    <h3>Username</h3>
                    <input type="text" value="<?php echo $username; ?>" id="username" name="Username" required>
                    <h3>Email</h3>
                    <input type="email" value="<?php echo $email; ?>" id="email" name="Email" required>
                    <h3>Phone</h3>
                    <input type="tel" value="<?php echo $phone; ?>" id="phone" name="Phone" required>
                    <h3>Password</h3>
                    <input type="password" name="Password" id="password" placeholder="**********">
                    <button type="submit">Change Image</button>
                </form>
                <form id="imageUpload" enctype="multipart/form-data" method="post" action="../../php/upload.php">
                    <h2>Profile Photo</h2>
                    <div id="displayProfile" alt="profile">
                        <div class="preview">
                            <?php
                            if (isset($row['Cust_image']) && $row['Cust_image'] !== null) {
                                echo "<img id='image-preview' src='../../Images/" . $row['Cust_image'] . "' alt='profile'>";
                            } else {
                                echo "<img id='image-preview' src='../../Images/default.png' alt='profile'>";
                            }
                            ?>

                        </div>
                        <label for="file-1">Upload Image</label>
                        <input type="file" id="file-1" name="image" accept="image/*" onchange="showPreview(event);">
                    </div>
                </form>
            </div>
            <div id="settings" class="settings">
                <h1>Confirm Log Out</h1>
                <p>Are you sure you want to log out?</p>
                <form class="logout-btn" action="../../php/logout.php" method="POST">
                    <button type="button" onclick="changeTabs('settings')">Cancel</button>
                    <button type="submit">Log Out</button>
                </form>
            </div>

            <?php
            if (isset($_GET['message'])) {
                $feedback = urldecode($_GET['message']);
                $animationstyle = "animation: slideleft 3s linear forwards";
                echo "<div class='error' style='" . $animationstyle . "'>";
                echo "<p id='error-message'>" . htmlspecialchars($feedback) . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
<script>
    function showPreview(event) {
        if (event.target.files.length > 0) {
            var form = document.getElementById("imageUpload");
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("image-preview");
            preview.src = src;
            preview.style.display = "flex";

            form.submit();
        }
    }
</script>

</html>