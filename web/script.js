// Initialize the map with default view
var map = L.map('map').setView([10.7332, 122.5585], 16); // Tabuc Suba coordinates

// Add the tile layer
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Initialize marker variable
var marker;

var tabucSubaBoundary = [
    [10.743164, 122.553640], // starting point of border coordinates
    [10.739383, 122.559256],
    [10.7384, 122.5585],
    [10.7376, 122.5596],
    [10.7371, 122.5599],
    [10.7358, 122.5610],
    [10.7352, 122.5603],
    [10.7328, 122.5647], // right upper corner
    [10.7282, 122.5647],
    [10.7254, 122.5631],
    [10.7242, 122.5596], // lower-right corner
    [10.7291, 122.5587],
    [10.7311, 122.5575],
    [10.7319, 122.5540],
    [10.7328, 122.5516], // lower left corner
    [10.743164, 122.553640] // back to starting point
];

var tabucSubaPolygon = L.polygon(tabucSubaBoundary, {
    color: "#3388ff",
    weight: 3,
    fill: true,
}).addTo(map);

function placeMarker(lat, lng, address) {

    if (marker) {
        map.removeLayer(marker);
    }

    marker = L.marker([lat, lng]).addTo(map);

    map.setView([lat, lng], 16);

    document.getElementById('presentAddress').value = address;
}

// Function to handle map clicks and update the address
function onMapClick(e) {
    // Remove the old marker if it exists
    if (marker) {
        map.removeLayer(marker);
    }
    // Add a new marker at the clicked location
    marker = L.marker(e.latlng).addTo(map);
    // Update the latitude and longitude fields with the clicked location
    document.getElementById('latitude').value = e.latlng.lat;
    document.getElementById('longitude').value = e.latlng.lng;

    // Fetch the address based on the clicked coordinates
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${e.latlng.lat}&lon=${e.latlng.lng}`)
        .then(response => response.json())
        .then(data => {
            // Set the present address field with the fetched address
            document.getElementById('presentAddress').value = data.display_name;
        })
        .catch(error => console.error('Error:', error));
}

// Attach the click event to the map
map.on('click', onMapClick);

// Function to calculate age based on the date of birth
function calculateAge(formCount) {
    const dobInput = document.getElementById(`dateOfBirth${formCount}`);
    const ageInput = document.getElementById(`age${formCount}`);
    
    const dobValue = dobInput.value;
    if (dobValue) {
        const dob = new Date(dobValue);
        const today = new Date();

        // Calculate age
        let age = today.getFullYear() - dob.getFullYear();
        const monthDifference = today.getMonth() - dob.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        ageInput.value = age; // Update the age field
    } else {
        ageInput.value = ''; // Clear the age field if no date is selected
    }
}

