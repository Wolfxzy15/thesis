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

function calculateAge(formCount) {
    const dobField = document.getElementById(`dateOfBirth${formCount}`);
    const ageField = document.getElementById(`age${formCount}`);

    const dob = new Date(dobField.value); // Get date of birth as a Date object
    const today = new Date(); // Get today's date

    let age = today.getFullYear() - dob.getFullYear();
    const monthDifference = today.getMonth() - dob.getMonth();
    const dayDifference = today.getDate() - dob.getDate();

    // Adjust if the birthday hasn't occurred yet this year
    if (monthDifference < 0 || (monthDifference === 0 && dayDifference < 0)) {
        age--;
    }

    ageField.value = age;

    document.getElementById('dateOfBirth').addEventListener('change', function () {
        const dob = this.value;
        if (dob) {
            const age = calculateAge(dob);
            document.getElementById('age').value = age;
        }
    });// Set the calculated age in the age input field


}


