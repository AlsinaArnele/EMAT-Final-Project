// Variables and DOM Elements
var navbar = document.querySelector('nav');
var mapElement = document.getElementById('map');
var routeSelect = document.getElementById('route');
var timeSelect = document.getElementById('time');
var usernameInput = document.getElementById('username');
var emailInput = document.getElementById('email');
var phoneInput = document.getElementById('phone');

// After page load, move navbar to the right
window.onload = function() {
    navbar.style.left = '0.45vw';
};

// Initialize map
var map = L.map('map').setView([-1.2921, 36.8219], 16);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

// Define custom icons
var customIcon = L.icon({
    iconUrl: 'Images/Location.png',
    iconSize: [38, 38], // size
    iconAnchor: [22, 22], // point of icon that corresponds with marker's location
    popupAnchor: [-3, -76]
});

var redIcon = L.icon({
    iconUrl: 'Images/Location.png',
    iconSize: [38, 38],
    iconAnchor: [22, 22],
    popupAnchor: [-3, -76]
});


var marker;

// update marker with users live location
navigator.geolocation.watchPosition(function(position) {
    var lat = position.coords.latitude;
    var long = position.coords.longitude;
    if (!marker) {
        marker = L.marker([lat, long], {icon: customIcon}).addTo(map);
    } else {
        marker.setLatLng([lat, long]);
    }
    map.panTo(new L.LatLng(lat, long));
}, function(error) {
    if (error.code === 1) {
        alert("Please allow location access!");
    } else {
        alert("Cannot get current location!");
    }
});

var destinations = [
    L.marker([-1.3567, 36.6561], {icon: redIcon}).addTo(map),
    L.marker([-1.286389, 36.817223], {icon: redIcon}).addTo(map),
    L.marker([-1.3943, 36.7628], {icon: redIcon}).addTo(map),
    L.marker([-1.3268, 36.7022], {icon: redIcon}).addTo(map)
];

function setTrack() {
    var route = routeSelect.value;
    var time = timeSelect.value;
    if (route !== 'default-route' && time !== 'default-time') {
        var destination;
        switch (route) {
            case 'Ngong':
                destination = L.latLng(-1.3567, 36.6561);
                break;
            case 'CBD':
                destination = L.latLng(-1.286389, 36.817223);
                break;
            case 'Rongai':
                destination = L.latLng(-1.3943, 36.7628);
                break;
            case 'Karen':
                destination = L.latLng(-1.3268, 36.7022);
                break;
            default:
                alert('Route not implemented yet!');
                return;
        }
        var control = L.Routing.control({
            routeWhileDragging: true,
            show: false,
            createMarker: function() {
                return null;
            }
        }).addTo(map);
        navigator.geolocation.watchPosition(function(position) {
            var lat = position.coords.latitude;
            var long = position.coords.longitude;
            control.setWaypoints([
                L.latLng(lat, long),
                destination
            ]);
        });
    } else {
        routeSelect.style.color = 'red';
        timeSelect.style.color = 'red';
    }
}

routeSelect.addEventListener('change', setTrack);
timeSelect.addEventListener('change', setTrack);

function changeTabs(tab) {
    var tabs = ['home', 'profile', 'history', 'report', 'settings'];
    tabs.forEach(function(item) {
        var currentTab = document.getElementById(item);
        var icon = document.getElementById(item + 'icon');
        if (tab === item) {
            currentTab.style.display = "flex";
            icon.style.backgroundColor = "#A1EEDF";
        } else {
            currentTab.style.display = "none";
            icon.style.backgroundColor = "transparent";
        }
    });
}

function submitFeedback(feedback) {
    var colors = ['black', 'red', 'orange', 'yellow', 'lime', 'green'];
    for (var i = 1; i <= 5; i++) {
        var element = document.getElementById(i.toString());
        if (i == feedback) {
            element.style.color = colors[i];
            element.style.transform = 'scale(.95)';
            document.getElementById('rating-holder').value = feedback;
        } else {
            element.style.color = 'black';
        }
    }
}
