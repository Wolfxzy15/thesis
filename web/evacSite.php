<?php include 'include/sidebar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evacuation Center</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #map {border: aliceblue solid; width: 700px; height: 300px; margin-top: 100px; display: grid;}

        body {
            justify-content: center;
            display: grid;
        }

        #inputbox {
            padding-left: 10px;
            margin: 10px;
            display: flex;
        }
    </style>
</head>
<body>
    

    <div id='map'>
    <script>
        var evac1_long = 10.730668;
        var evac1_lat = 122.560212;
        var evac2_long =10.733978;
        var evac2_lat = 122.557465;
        var evac3_long = 10.733936;
        var evac3_lat = 122.561885;
        var evac1_distance, evac2_distance, evac3_distance;



        var map = L.map('map').setView([10.731019, 122.558467], 15);
        L.tileLayer('https://api.maptiler.com/maps/streets-v2/256/{z}/{x}/{y}.png?key=ngrPpvE2X0m7KBaoLLex', {
            attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTile  r</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>'
        }).addTo(map);

        // Red marker icon
        var ClickIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34]
        });

        // Add red marker
        

        // Other markers
        var markers = [
            {coords: [evac1_long, evac1_lat], name: 'Marker 1'},
            {coords: [evac2_long, evac2_lat], name: 'Marker 2'},
            {coords: [evac3_long, evac3_lat], name: 'Marker 3'}
        ];

        markers.forEach(function(markerData) {
            var marker = L.marker(markerData.coords).addTo(map);
            marker.bindPopup(markerData.name).openPopup();});

            var clickMarker;
        map.on('click', function(e) {
            // If a marker already exists, remove it
            if (clickMarker) {
                map.removeLayer(clickMarker);
            }

            // Get the click coordinates
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Add a new marker at the clicked location
            clickMarker = L.marker([lat, lng], {icon: ClickIcon}).addTo(map);
            clickMarker.bindPopup('You clicked at ' + lat.toFixed(5) + ', ' + lng.toFixed(5)).openPopup();

            document.getElementById('latitude').value = lat.toFixed(5);
            document.getElementById('longitude').value = lng.toFixed(5)
        });

        
    </script>

    
    </div>
    <div id="inputbox">
        <input type="text" class="form-control" id="latitude">
        <input type="text" class="form-control" id="longitude">
    </div>
    
</body>
</html>