<?php
session_start();
include '../../php/admin-session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emat | Admin</title>
    <link rel="stylesheet" href="../../css/admin.css">
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
    <nav>
        <img src="Images/Login-image.png" alt="profile">
        <p onclick="changeTabs('dashboard')" id="dashboardicon">
            <span class="material-symbols-outlined">home</span>
            <span id="toHide">Dashboard</span>
        </p>
        <p onclick="changeTabs('users')" id="usersicon">
            <span class="material-symbols-outlined">person</span>
            <span id="toHide">Users</span>
        </p>
        <p onclick="changeTabs('drivers')" id="driversicon">
            <span class="material-symbols-outlined">id_card</span>
            <span id="toHide">Drivers</span>
        </p>
        <p onclick="window.location.href='Admin-Ticketing.php'" id="ticketsicon">
            <span class="material-symbols-outlined">confirmation_number</span>
            <span id="toHide">Tickets</span>
        </p>
        <p onclick="window.location.href='Admin-Ticketing.php'" style="margin-top: 2vh;" id="feedbackicon">
            <span class="material-symbols-outlined">flag</span>
            <span id="toHide">Reports</span>
        </p>
        <p onclick="window.location.href='Admin-Ticketing.php'" style="margin-top: 2vh;" id="routesicon">
            <span class="material-symbols-outlined">flyover</span>
            <span id="toHide">Routes & Schedules</span>
        </p>
        <p></p>
        <p onclick="changeTabs('settings')" id="settingsicon">
            <span class="material-symbols-outlined">logout</span>
            <span id="toHide">Log Out</span>
        </p>
    </nav>
    <!-- TABS -->
    <div class="container">
        <div class="container-nav">
            <div class="greetings">
                <h2>Good Day, </h2>
            </div>
            <h2 id="timeDisplay"><?php echo date("l jS F"); ?></h2>
        </div>
        <div id="dashboard">
            <div class="map-display" id="map"></div>
        </div>

        <div id="users">
            <form class="users_search" action="" method="GET">
                <input type="text" name="search" placeholder="Search by username or email">
                <button type="submit">Search</button>
                <select name="users-filter" id="filter">
                    <option value="Cust_name" selected>Name</option>
                    <option value="Cust_email">Email</option>
                </select>
                <select name="users-ascending-filter" id="filter">
                    <option value="ASC" selected>Asc</option>
                    <option value="DESC">Desc</option>
                </select>
                <button type="submit">Apply filter</button>
            </form>
            <table class="accounts">
                <tr class="head-tr">
                    <th class="profile-image">Photo</th>
                    <th class="username">Username</th>
                    <th class="email">Email</th>
                    <th class="status">Status</th>
                    <th class="actions">Actions</th>
                </tr>
                <?php
                include '../../php/fetch-users.php';
                ?>
            </table>
        </div>

        <div id="drivers">
            <form class="drivers_search" action="" method="GET">
                <input type="text" name="drivers_search" placeholder="Search by username or email">
                <button type="submit">Search</button>
                <select name="drivers-filter" id="filter">
                    <option value="Driver_name" selected>Name</option>
                    <option value="Driver_email">Email</option>
                </select>
                <select name="users-ascending-filter" id="filter">
                    <option value="ASC" selected>Asc</option>
                    <option value="DESC">Desc</option>
                </select>
                <button type="submit">Apply filter</button>
            </form>
            <table class="accounts">
                <tr class="head-tr">
                    <th class="profile-image">Photo</th>
                    <th class="username">Driver Name</th>
                    <th class="email">Driver Email</th>
                    <th class="status">Status</th>
                    <th class="actions">Actions</th>
                </tr>
                <?php
                include '../../php/fetch-drivers.php';
                ?>
            </table>
        </div>

        <div id="settings" class="settings">
            <h1>Confirm Log Out</h1>
            <p>Are you sure you want to log out?</p>
            <form class="logout-btn" action="../../php/admin-logout.php" method="POST">
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
    <div class="logincontainer" <?php echo $style ?>>
        <form class="loginform" action="../../php/adminlogin.php" method="POST">
            <h1>Admin Login.</h1>
            <div class="textbox">
                <h3>Username</h3>
                <input type="text" name="adminusername" required>
            </div>
            <div class="textbox">
                <h3>Password</h3>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Log In</button>
        </form>
    </div>
</body>
<script>
    const navbar = document.querySelector('nav');
    const mapElement = document.getElementById('map');
    const routeSelect = document.getElementById('route');
    const timeSelect = document.getElementById('time');
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    let activeTab = null;

    // Initialize map
    if (mapElement) {
        const map = L.map('map').setView([-1.351111, 36.757778], 14);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 20,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Create custom icons for different entities(eg. bus, school, location and user)
        const busIcon = L.icon({
            iconUrl: 'Images/bus.png',
            iconSize: [38, 38],
            iconAnchor: [22, 22],
            popupAnchor: [-3, -76]
        });
        const schoolIcon = L.icon({
            iconUrl: 'Images/education.png',
            iconSize: [38, 38],
            iconAnchor: [22, 22],
            popupAnchor: [-3, -76]
        });
        const redIcon = L.icon({
            iconUrl: 'Images/Location.png',
            iconSize: [38, 38],
            iconAnchor: [22, 22],
            popupAnchor: [-3, -76]
        });

        // Add markers to map
        const destinations = [
            L.marker([-1.351111, 36.757778], {
                icon: schoolIcon
            }).addTo(map),
            L.marker([-1.3567, 36.6561], {
                icon: redIcon
            }).addTo(map),
            L.marker([-1.286389, 36.817223], {
                icon: redIcon
            }).addTo(map),
            L.marker([-1.3943, 36.7628], {
                icon: redIcon
            }).addTo(map),
            L.marker([-1.3268, 36.7022], {
                icon: redIcon
            }).addTo(map)
        ];
    }

    // change tabs and highlight selected tab
    function changeTabs(tab) {
        const tabs = ['dashboard', 'users', 'drivers', 'feedback', 'tickets', 'routes', 'settings'];

        const currentTabElement = document.getElementById(tab);
        const currentIconElement = document.getElementById(tab + 'icon');

        if (!currentTabElement || !currentIconElement) return;

        if (activeTab === tab) {
            currentTabElement.style.display = "none";
            currentIconElement.style.backgroundColor = "transparent";
            activeTab = null;
        } else {
            tabs.forEach(function(item) {
                const tabElement = document.getElementById(item);
                const iconElement = document.getElementById(item + 'icon');
                if (tabElement && iconElement) {
                    if (tab === item) {
                        tabElement.style.display = "flex";
                        iconElement.style.backgroundColor = "#88AB8E";
                        activeTab = tab;
                    } else {
                        tabElement.style.display = "none";
                        iconElement.style.backgroundColor = "transparent";
                    }
                }
            });
        }
    }

    function deleteRow(email, table) {
        if (confirm('Are you sure you want to delete this entry?')) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../../php/delete.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert('Entry deleted successfully.');
                    location.reload();
                }
            };
            xhr.send('email=' + encodeURIComponent(email) + '&table=' + encodeURIComponent(table));
        }
    }


    function editRow(email) {
        window.location.href = '../php/edit.php?email=' + encodeURIComponent(email);
    }
</script>

</html>