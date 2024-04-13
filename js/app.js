    var map = L.map('map').setView([-1.2921, 36.8219], 16);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker;
    
    navigator.geolocation.watchPosition(function(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        
        if (!marker) {
            marker = L.marker([lat, long]).addTo(map);
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
    
    var route = document.getElementById('route').value;
    var time = document.getElementById('time').value;
    if(route === 'Choose Route' && time === 'Choose Time'){
        document.querySelector('route').style.color = 'red';
        document.querySelector('time').style.color = 'red';
    }

    function expandControls() {
        var route = document.getElementById('route').value;
        var time = document.getElementById('time').value;
        if (route !== 'default-route' && time !== 'default-time') {
            document.querySelector('nav').style.display = 'none';
            document.getElementById('route2').value = route;
            document.getElementById('time2').value = time;

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
        }
        else {
            document.querySelector('route').style.color = 'red';
            document.querySelector('time').style.color = 'red';
        }
    }
    document.getElementById('time').addEventListener('change', expandControls);
    document.getElementById('route').addEventListener('change', expandControls);

    function changeTabs(tab){
        if(tab == 'home'){
            document.querySelector('home').style.display = 'flex';
        }
    }

