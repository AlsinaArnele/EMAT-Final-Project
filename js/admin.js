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
        L.marker([-1.351111, 36.757778], { icon: schoolIcon }).addTo(map),
        L.marker([-1.3567, 36.6561], { icon: redIcon }).addTo(map),
        L.marker([-1.286389, 36.817223], { icon: redIcon }).addTo(map),
        L.marker([-1.3943, 36.7628], { icon: redIcon }).addTo(map),
        L.marker([-1.3268, 36.7022], { icon: redIcon }).addTo(map)
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
        tabs.forEach(function (item) {
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
function deleteRow(email) {
    if (confirm('Are you sure you want to delete this driver?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../php/delete.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert('Driver deleted successfully.');
                location.reload();
            }
        };
        xhr.send('email=' + encodeURIComponent(email));
    }
}

function editRow(email) {
    // Redirect to an edit page with the driver's email as a query parameter
    window.location.href = '../php/edit.php?email=' + encodeURIComponent(email);
}

