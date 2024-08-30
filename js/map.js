// Variables and DOM Elements
var mapElement = document.getElementById("map");
var routeSelect = document.getElementById("route");
var timeSelect = document.getElementById("time");
var usernameInput = document.getElementById("username");
var emailInput = document.getElementById("email");
var phoneInput = document.getElementById("phone");

// Initialize map
var map = L.map("map").setView([-1.2921, 36.8219], 14);
L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 20,
  attribution:
    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

var schoolIcon = L.icon({
  iconUrl: "../../js/education.png",
  iconSize: [38, 38],
  iconAnchor: [22, 22],
  popupAnchor: [-3, -76],
});

var customIcon = L.icon({
  iconUrl: "../../js/Location.png",
  iconSize: [38, 38], // size
  iconAnchor: [22, 22], // point of icon that corresponds with marker's location
  popupAnchor: [-3, -76],
});

var redIcon = L.icon({
  iconUrl: "../../js/Location.png",
  iconSize: [38, 38],
  iconAnchor: [22, 22],
  popupAnchor: [-3, -76],
});

var marker;

// update marker with users live location
navigator.geolocation.watchPosition(
  function (position) {
    var lat = position.coords.latitude;
    var long = position.coords.longitude;
    if (!marker) {
      marker = L.marker([lat, long], { icon: customIcon }).addTo(map);
    } else {
      marker.setLatLng([lat, long]);
    }
    map.panTo(new L.LatLng(lat, long));
  },
  function (error) {
    if (error.code === 1) {
      alert("Please allow location access!");
    } else {
      alert("Cannot get current location!");
    }
  }
);

var destinations = [
  L.marker([-1.351111, 36.757778], { icon: schoolIcon }).addTo(map),
  L.marker([-1.3567, 36.6561], { icon: redIcon }).addTo(map),
  L.marker([-1.286389, 36.817223], { icon: redIcon }).addTo(map),
  L.marker([-1.3943, 36.7628], { icon: redIcon }).addTo(map),
  L.marker([-1.3268, 36.7022], { icon: redIcon }).addTo(map),
];

function setTrack() {
  var route = routeSelect.value;
  if (route !== "default-route") {
    var destination;

      switch (route) {
        case "990":
          destination = L.latLng(-1.3567, 36.6561);
          break;
        case "989":
          destination = L.latLng(-1.286389, 36.817223);
          break;
        case "991":
          destination = L.latLng(-1.3943, 36.7628);
          break;
        case "Karen":
          destination = L.latLng(-1.3268, 36.7022);
          break;
        default:
          alert("Route not implemented yet!");
          return;
      }
    var control = L.Routing.control({
      routeWhileDragging: true,
      show: false,
      createMarker: function () {
        return null;
      },
    }).addTo(map);
    navigator.geolocation.watchPosition(function (position) {
      var lat = position.coords.latitude;
      var long = position.coords.longitude;
      control.setWaypoints([L.latLng(-1.351111, 36.757778), destination]);
    });
  } else if (route !== "default-route" && time === "default-time") {
    timeSelect.style.color = "red";
  } else {
    routeSelect.style.color = "red";
  }
}

window.onload = function () {
  if (document.getElementById("sessionroute")) {
    var destinationtext = document.getElementById("sessionroute").value;
    if (destinationtext === "Ngong") {
      routeSelect.value = "990";
      setTrack();
    } else if (destinationtext === "CBD") {
      routeSelect.value = "989";
      setTrack();
    }
    else if (destinationtext === "Rongai") {
      routeSelect.value = "991";
      setTrack();
    }
    setTrack();
  }else if (document.getElementById("ticketroute")) {
    var destinationtext = document.getElementById("sessionroute").value;
    if (destinationtext === "Ngong") {
      routeSelect.value = "990";
      setTrack();
    } else if (destinationtext === "CBD") {
      routeSelect.value = "989";
      setTrack();
    }
    else if (destinationtext === "Rongai") {
      routeSelect.value = "991";
      setTrack();
    }
    setTrack();
  }
  else{
    routeSelect.addEventListener("change", setTrack);
  }
};

function changeTabs(tab) {
  if (tab === "settings") {
    document.getElementById("settings").style.display = "flex";
  } else {
    document.getElementById("settings").style.display = "none";
  }
}

function submitFeedback(feedback) {
  var colors = ["black", "red", "orange", "yellow", "lime", "green"];
  for (var i = 1; i <= 5; i++) {
    var element = document.getElementById(i.toString());
    if (i == feedback) {
      element.style.color = colors[i];
      element.style.transform = "scale(.95)";
      document.getElementById("rating-holder").value = feedback;
    } else {
      element.style.color = "black";
    }
  }
}

function navDisplay() {
  var nav = document.getElementById("nav");
  if (nav.style.left === "60vw") {
    nav.style.left = "100vw";
  } else {
    nav.style.left = "60vw";
  }
}

function toggleImage() {
  var imgForm = document.getElementById("imageUpload");
  if (imgForm.style.display === "none") {
    imgForm.style.display = "flex";
  } else {
    imgForm.style.display = "none";
  }
}

function clearRoute() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "../../php/clearRoute.php", true);
  xhr.send();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log("Route Cleared");
    }
  };
}

function profile() {
  var profilediv = document.getElementById("profile");
  var otherdiv = document.querySelector(".scheduling");
  var detailsdiv = document.querySelector(".details");
  if (profilediv.style.display === "flex") {
    profilediv.style.display = "none";
    otherdiv.style.display = "flex";
    detailsdiv.style.display = "flex";
  } else {
    profilediv.style.display = "flex";
    otherdiv.style.display = "none";
    detailsdiv.style.display = "none";
  }
}

let minutes = 0;
let seconds = 0;

function updateTimer() {
  minutes++;
  if (minutes === 60) {
    minutes = 0;
  }

  const now = new Date();
  const daysOfWeek = [
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
  ];
  const day = daysOfWeek[now.getDay()];
  const hours = now.getHours();
  const period = hours >= 12 ? "PM" : "AM";
  const formattedHours = hours % 12 === 0 ? 12 : hours % 12;
  const formattedMinutes = minutes < 10 ? "0" + minutes : minutes;

  document.getElementById(
    "timeDisplay"
  ).innerText = `${day} ${formattedHours}:${formattedMinutes} ${period}`;
}

setInterval(updateTimer, 60000);
updateTimer();

function logout() {
  if (confirm("Are you sure you want to logout?")) {
    var form = document.getElementById("logout");
    form.submit();
  }
}
function destroyCookie() {
  var cookieform = document.getElementById("destroy");
  cookieform.submit();
}
