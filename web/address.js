// Initialize the map with default view
var map = L.map('map').setView([10.7332, 122.5585], 16); // Tabuc Suba coordinates

// Add the tile layer
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Initialize marker variable
var marker;

// Function to place a marker on the map and set the address field
function placeMarker(lat, lng, address) {
    if (marker) {
        map.removeLayer(marker);
    }
    marker = L.marker([lat, lng]).addTo(map);
    map.setView([lat, lng], 16); // Zoom to the marker location
    document.getElementById('presentAddress').value = address;
}

// Retrieve saved latitude, longitude, and present address from the PHP script
var savedLatitude = parseFloat(document.getElementById('latitude').value);
var savedLongitude = parseFloat(document.getElementById('longitude').value);
var savedAddress = document.getElementById('presentAddress').value;

// Place the marker if latitude and longitude are provided
if (!isNaN(savedLatitude) && !isNaN(savedLongitude)) {
    placeMarker(savedLatitude, savedLongitude, savedAddress);
} else {
    console.warn('Invalid or missing latitude/longitude.');
}

// Function to handle map clicks and update the address
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

// Attach the click event to the map
map.on('click', onMapClick);
