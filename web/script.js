//MAP FUNCTION
var map = L.map('map').setView([10.7332, 122.5585], 16); //Tabuc Suba coordinates

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var savedLatitude = document.getElementById('latitude').value;
var savedLongitude = document.getElementById('longitude').value;
var marker;

if (savedLatitude && savedLongitude) {
    var savedLatLng = L.latLng(savedLatitude, savedLongitude);
    marker = L.marker(savedLatLng).addTo(map); 
    map.setView(savedLatLng, 16); 

    
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${savedLatitude}&lon=${savedLongitude}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('presentAddress').value = data.display_name; 
        })
        .catch(error => console.error('Error:', error));
}

function onMapClick(e) {
    if (marker) {
        map.removeLayer(marker);
    }
    marker = L.marker(e.latlng).addTo(map);
    document.getElementById('latitude').value = e.latlng.lat;
    document.getElementById('longitude').value = e.latlng.lng;

    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${e.latlng.lat}&lon=${e.latlng.lng}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('presentAddress').value = data.display_name;
        })
        .catch(error => console.error('Error:', error));
}

map.on('click', onMapClick);