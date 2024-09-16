<?php 
include 'db.php'; // Connect to the database

// Default coordinates for Brgy. Tabuc Suba, Jaro, Iloilo City
$defaultLat = 10.7344;
$defaultLong = 122.5580;

// Query evacuation centers
$sql = "SELECT evacID, evacName, latitude, longitude, max_capacity, current_capacity FROM tbl_evac_centers";
$evacCenters = mysqli_query($conn, $sql);

$evacData = []; // Store evacuation centers data

while ($row = mysqli_fetch_assoc($evacCenters)) {
    $evacData[] = $row; // Store evacuation center information
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="./assets/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-Df2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
</head>
<body>
<?php include 'include/sidebar.php'; ?>
<main>
<div class="container1">
<h2>Evacuation Centers in Brgy. Tabuc Suba, Jaro, Iloilo City</h2>

<div id='map' style="height: 600px;"></div>
</div>
<br>
<table class="table table-dark">
    <thead class="thead-dark">
    <tr>
        <th scope="col">LEGEND</th>
        <th scope="col">Description</th>
    </tr>
    </thead>
        <tbody>
            <tr>
                <th scope="row"><i class="fa-solid fa-building"></i></th>
                <td>- Evacuation Centers</td>
            </tr>
        </tbody>
</table>



<script>
// Default coordinates for the map (Brgy. Tabuc Suba)
var defaultLat = <?= $defaultLat; ?>;
var defaultLong = <?= $defaultLong; ?>;
var evacCenters = <?= json_encode($evacData); ?>;

// Initialize the map centered at Brgy. Tabuc Suba
var map = L.map('map').setView([defaultLat, defaultLong], 16);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

// Add evacuation centers to the map
evacCenters.forEach(function(evac) {
    var evacLat = evac.latitude;
    var evacLong = evac.longitude;
    var evacName = evac.evacName;

    var evacIcon = L.icon({iconUrl: "images/building-solid.svg", iconSize:[35,35]})
    L.marker([evacLat, evacLong], {icon: evacIcon}).addTo(map)
        .bindTooltip(evacName)
        .openTooltip();
});
</script>

</main>
</body>
</html>
