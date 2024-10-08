// Initialize the map with default view
var map = L.map('map').setView([10.7332, 122.5585], 16); // Tabuc Suba coordinates

// Add the tile layer
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Initialize marker variable
var marker;

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

