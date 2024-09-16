<?php
include 'db.php'; // Connect to the database

// Function to calculate distance using Haversine Formula
function haversine($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371; // Earth radius in kilometers
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat/2) * sin($dLat/2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $earth_radius * $c; // Distance in kilometers
}

// Check if the family data is received
if (isset($_GET['family_id']) && isset($_GET['latitude']) && isset($_GET['longitude'])) {
    $familyID = $_GET['family_id'];
    $familyLat = $_GET['latitude'];
    $familyLong = $_GET['longitude'];

    // Query evacuation centers
    $sql = "SELECT evacID, evacName, latitude, longitude, max_capacity, current_capacity FROM tbl_evac_centers";
    $evacCenters = mysqli_query($conn, $sql);
    
    $evacData = []; // Store evacuation centers data
    $nearestEvac = null; // Track the nearest evacuation center
    $minDistance = PHP_FLOAT_MAX; // Initialize the minimum distance to a very large number

    while ($row = mysqli_fetch_assoc($evacCenters)) {
        $evacLat = $row['latitude'];
        $evacLong = $row['longitude'];
        $distance = haversine($familyLat, $familyLong, $evacLat, $evacLong);

        // Store evacuation data with calculated distance
        $evacData[] = array_merge($row, ['distance' => $distance]);

        // Find the nearest evacuation center that is not full
        if ($distance < $minDistance && $row['current_capacity'] < $row['max_capacity']) {
            $minDistance = $distance;
            $nearestEvac = $row;
        }
    }

    // Check if the nearest evacuation center is full
    if (!$nearestEvac) {
        $evacData = array_filter($evacData, function($evac) {
            return $evac['current_capacity'] < $evac['max_capacity'];
        });

        usort($evacData, function($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });

        $nearestEvac = $evacData[0] ?? null;
    }

    if (isset($_POST['register']) && isset($_POST['evac_id'])) {
        $evacID = $_POST['evac_id'];

        
        $update_sql = "UPDATE tbl_families SET evacID = '$evacID', evacStatus = 'EVACUATED' WHERE family_id = '$familyID'";
        if (mysqli_query($conn, $update_sql)) {
            
            $update_evac_sql = "UPDATE tbl_evac_centers SET current_capacity = current_capacity + 1 WHERE evacID = '$evacID'";
            mysqli_query($conn, $update_evac_sql);
            
            $success = true; 
        } else {
            echo "Error registering the family: " . mysqli_error($conn);
            $success = false; 
        }
    }
} else {
    echo "Family data not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="./assets/favicon.ico" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0JLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php include 'include/sidebar.php'; ?>
<main>
<div class="container1">

<h2>Evacuation Site Family Registration</h2>

<!-- Show the nearest evacuation center and distance -->
<p>Nearest Evacuation Center: <strong><?= $nearestEvac['evacName']; ?></strong></p>
<p>Distance: <strong><?= round($minDistance, 2); ?> km</strong></p>

<div id='map' style="height: 600px;"></div>
<br>
<form method="POST">
    <input type="hidden" name="family_id" value="<?= $familyID; ?>">
    <select name="evac_id" id="evacSelect" required>
        <option value="<?= $nearestEvac['evacID']; ?>">Nearest Evacuation Center (<?= round($minDistance, 2); ?> km)</option>
        <?php foreach ($evacData as $evac) { ?>
            <option value="<?= $evac['evacID']; ?>"><?= $evac['evacName']; ?> (<?= round($evac['distance'], 2); ?> km)</option>
        <?php } ?>
    </select>
    <button type="submit" name="register">Register</button>
</form>
</div>

<script>
// Family and evacuation center coordinates from PHP
var familyLat = <?= $familyLat; ?>;
var familyLong = <?= $familyLong; ?>;
var evacCenters = <?= json_encode($evacData); ?>;
var familyID = <?= json_encode($familyID); ?>;
var success = <?= isset($success) && $success ? 'true' : 'false'; ?>;

// Initialize map centered at the family's location
var map = L.map('map').setView([familyLat, familyLong], 18);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

// Add family location marker
L.marker([familyLat, familyLong]).addTo(map)
    .bindPopup("Family: " + familyID + " Location")
    .openPopup();

// Add evacuation centers to the map
evacCenters.forEach(function(evac) {
    var evacLat = evac.latitude;
    var evacLong = evac.longitude;
    var evacName = evac.evacName;

    var evacIcon = L.icon({iconUrl: "images/building-solid.svg", iconSize:[32,32]});
    L.marker([evacLat, evacLong], {icon: evacIcon}).addTo(map)
        .bindTooltip(evacName)
        .openTooltip();
});

// Show SweetAlert on successful registration
if (success) {
    Swal.fire({
        title: 'Success!',
        text: 'Family has been successfully registered in the evacuation center.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
              window.location.href = 'displayFamilies.php';
    });
}
</script>

</main>
</body>
</html>
