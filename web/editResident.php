<?php

include "include/db.php";
if (isset($_GET['updateID'])) {
    $id = $_GET['updateID'];
    $sql = "SELECT * FROM tbl_residents where residentID=$id";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $kinship = $row["kinship"];
        $lastName = $row["lastName"];
        $fName = $row["fName"];
        $mName = $row["mName"];
        $age = $row["age"];
        $presentAdd = $row["presentAdd"];
        $provAdd = $row["provAdd"];
        $sex = $row["sex"];
        $civilStat = $row["civilStat"];
        $dateOfBirth = $row["dateOfBirth"];
        $placeOfBirth = $row["placeOfBirth"];
        $height = $row["height"];
        $weight = $row["weight"];
        $contactNo = $row["contactNo"];
        $religion = $row["religion"];
        $emailAdd = $row["emailAdd"];
        $famComposition = $row["famComposition"];
        $pwd = $row["pwd"];
        $latitude = $row["latitude"];
        $longitude = $row["longitude"];
    } else {
        die("No resident found with ID: $id");
    }
} else {
    die("Update ID is not set.");
}


if (isset($_POST["update"])) {
    $kinship = $_POST["kinship"];
    $lastName = $_POST["lastName"];
    $fName = $_POST["fName"];
    $mName = $_POST["mName"];
    $age = $_POST["age"];
    $presentAdd = mysqli_real_escape_string($conn, $_POST["presentAdd"]);
    $provAdd = $_POST["provAdd"];
    $sex = $_POST["sex"];
    $civilStat = $_POST["civilStat"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $placeOfBirth = $_POST["placeOfBirth"];
    $height = $_POST["height"];
    $weight = $_POST["weight"];
    $contactNo = $_POST["contactNo"];
    $religion = $_POST["religion"];
    $emailAdd = $_POST["emailAdd"];
    $famComposition = $_POST["famComposition"];
    $pwd = $_POST["pwd"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];


    if (
        empty($kinship) || empty($lastName) || empty($fName) || empty($mName) || empty($presentAdd) || empty($age) || empty($provAdd) || empty($civilStat) || empty($dateOfBirth) || empty($placeOfBirth) || empty($height) || empty($weight) || empty($contactNo) || empty($religion) || empty($emailAdd) ||
        empty($famComposition) || empty($pwd)
    ) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('formIncompleteNotification');
            notification.style.display = 'block';
            setTimeout(function() {
                notification.style.display = 'none';
            }, 3000); // Hide after 3 seconds
        });
      </script>";
    }
    
    $sql = "UPDATE tbl_residents SET residentID=$id, kinship = '$kinship', lastName = '$lastName', fName = '$fName', mName = '$mName', age = '$age', presentAdd = '$presentAdd', 
    provAdd = '$provAdd', sex = '$sex', civilStat = '$civilStat', dateOfBirth = '$dateOfBirth', placeOfBirth = '$placeOfBirth', height = '$height',
    weight = '$weight', contactNo = '$contactNo', religion = '$religion', emailAdd = '$emailAdd', famComposition = '$famComposition' ,pwd = '$pwd', latitude = '$latitude', longitude = '$longitude' where residentID=$id";

    $presentAddEscaped = mysqli_real_escape_string($conn, $presentAdd);
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('notification');
            notification.style.display = 'block';
            setTimeout(function() {
                notification.style.display = 'none';
            }, 3000); // Hide after 3 seconds
        });
      </script>";
    } else {
        die(mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>index</title>
    <link rel="icon" type="image/x-icon" href="./assets/favicon.ico" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>


<style>
    #notification {
        display: none;
        position: fixed;
        background-color: #28a745;
        color: white;
        left: 50%;
        top: 12%;
        transform: translate(-50%, -50%);
        width: 80%;
        text-align: center;
        padding: 10px;
        border-radius: 5px;
        z-index: 1000;
    }

    #formIncompleteNotification {
        display: none;
        position: fixed;
        background-color: #dc3545;
      color: white;
        left: 50%;
        top: 12%;
        transform: translate(-50%, -50%);
        width: 80%;
        text-align: center;
        padding: 10px;
        border-radius: 5px;
        z-index: 1000;
    }
    #map {
            height: 400px;
            margin-top: 10px;
            width: 100%;
        }
</style>

<body style="background-image: url('https://dynamic-media-cdn.tripadvisor.com/media/photo-o/06/e0/4c/2d/iloilo-city-hall.jpg?w=1200&h=-1&s=1');
  background-repeat: no-repeat;
  background-size: cover;">
    <?php include 'include/nav.php'; ?>
    <div id="notification">Updated Successfully</div>
    <div id="formIncompleteNotification">Please fill up the form completely</div>

    <div class="container" style="background-color: aliceblue; border-radius: 5px; padding: 12px; margin: auto;">
        <form autocomplete="off" action="" method="post">
            <input type="hidden" id="action" value="register">
            <h2 style="text-align: center;">Update Information</h2>
            <div class="row row-cols-2 mb-3">
                <div class="col-md-4 mb-2">
                    <label for="lastName">Lastname:</label>
                    <input type="text" class="form-control" value="<?php echo $lastName; ?>" placeholder="Last name" id="lastName" name="lastName">
                </div>
                <div class="col-md-4">
                    <label for="fName">Firstname:</label>
                    <input type="text" class="form-control" value="<?php echo $fName; ?>" placeholder="First name" id="fName" name="fName">
                </div>
                <div class="col-md-4">
                    <label for="mName">Middlename:</label>
                    <input type="text" class="form-control" value="<?php echo $mName; ?>" placeholder="Middle name" id="mName" name="mName">
                </div>
                <div class="col-md-4">
                    <label for="age">Age:</label>
                    <input type="text" class="form-control" value="<?php echo $age; ?>" placeholder="" id="age" name="age">
                </div>
                <div class="col-md-7">
                    <label for="kinship">Kinship Position:</label>
                    <select id="kinship" name="kinship" class="form-control">
                        <option value="">--Position--</option>
                        <option value="Head of Family" <?php echo ($kinship == 'Head of Family') ? 'selected' : ''; ?>>Head of Family</option>
                        <option value="Spouse" <?php echo ($kinship == 'Spouse') ? 'selected' : ''; ?>>Spouse</option>
                        <option value="Solo Parent" <?php echo ($kinship == 'Solo Parent') ? 'selected' : ''; ?>>Solo Parent</option>
                        <option value="Solo Living" <?php echo ($kinship == 'Solo Living') ? 'selected' : ''; ?>>Solo Living</option>
                        <option value="Dependent" <?php echo ($kinship == 'Dependent') ? 'selected' : ''; ?>>Dependent</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="row row-cols-2 mb-3">
                <div class="col-md-6">
                    <label for="presentAdd">Present Address:</label>
                    <input type="text" class="form-control" value="<?php echo $presentAdd; ?>" placeholder="Present Address" id="presentAdd" name="presentAdd" required readonly>
                    <div id="map"></div>
                    <input type="hidden" id="latitude" value="<?php echo $latitude; ?>" name="latitude">
                    <input type="hidden" id="longitude" value="<?php echo $longitude; ?>" name="longitude">
                </div>
                <div class="col-md-6">
                    <label for="provAdd">Provincial Address:</label>
                    <input type="text" class="form-control" value="<?php echo $provAdd; ?>" placeholder="Provincial Address" id="provAdd" name="provAdd">
                </div>
            </div>
            <div class="row row-cols-2 mb-3"> <!-- Added mb-3 class to add margin-bottom -->
                <div class="col-md-2 mb-2">
                    <label for="sex">Sex:</label>
                    <input type="radio" value="Female" id="female" name="sex" <?php echo ($sex == 'Female') ? 'checked' : ''; ?>>Female
                    <input type="radio" value="Male" id="male" name="sex" <?php echo ($sex == 'Male') ? 'checked' : ''; ?>>Male
                </div>
                <div class="col-md-4 mb-2">
                    <label for="civilStat">Civil Status:</label>
                    <select id="civilStat" name="civilStat" class="form-control">
                        <option value="">--Status--</option>
                        <option value="Single" <?php echo ($civilStat == 'Single') ? 'selected' : ''; ?>>Single</option>
                        <option value="Married" <?php echo ($civilStat == 'Married') ? 'selected' : ''; ?>>Married</option>
                        <option value="Widowed" <?php echo ($civilStat == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
                        <option value="Separated" <?php echo ($civilStat == 'Separated') ? 'selected' : ''; ?>>Separated</option>

                    </select>
                </div>
                <div class="col-md-2">
                    <label for="dateOfBirth">Date Of Birth:</label>
                    <input type="text" class="form-control" value="<?php echo $dateOfBirth; ?>" placeholder="mm/dd/yyyy" id="dateOfBirth" name="dateOfBirth">
                </div>
                <div class="col-md-4">
                    <label for="placeOfBirth">Place Of Birth:</label>
                    <input type="text" class="form-control" value="<?php echo $placeOfBirth; ?>" placeholder="" id="placeOfBirth" name="placeOfBirth">
                </div>
            </div>
            <div class="row row-cols-2 mb-3"> <!-- Added mb-3 class to add margin-bottom -->
                <div class="col-md-2 mb-2">
                    <label for="height">Height:</label>
                    <input type="number" class="form-control" value="<?php echo $height; ?>" placeholder="cm" id="height" name="height">
                </div>
                <div class="col-md-2 mb-2">
                    <label for="weight">Weight:</label>
                    <input type="number" class="form-control" value="<?php echo $weight; ?>" placeholder="kg" id="weight" name="weight">
                </div>
                <div class="col-md-4 mb-2">
                    <label for="contactNo">Contact Number:</label>
                    <input type="text" class="form-control" value="<?php echo $contactNo; ?>" placeholder="" id="contactNo" name="contactNo">
                </div>
                <div class="col-md-4 mb-4">
                    <label for="religion">Religion:</label>
                    <input type="text" class="form-control" value="<?php echo $religion; ?>" placeholder="ex.Roman Catholic" id="religion" name="religion">
                </div>
                <div class="col-md-4">
                    <label for="emailAdd">Email Address:</label>
                    <input type="text" class="form-control" value="<?php echo $emailAdd; ?>" placeholder="@email.com" id="emailAdd" name="emailAdd">
                </div>
                <div class="col-md-4">
                    <label for="famComposition">Number of Household Occupants:</label>
                    <input type="text" class="form-control" value="<?php echo $famComposition; ?>" placeholder="" id="famComposition" name="famComposition">
                </div>
                <div class="col-md-4">
                    <label for="pwd">Are you a person with disability?</label>
                    <input type="radio" value="YES" id="yes" name="pwd" <?php echo ($pwd == 'YES') ? 'checked' : ''; ?>>YES
                    <input type="radio" value="NO" id="no" name="pwd" <?php echo ($pwd == 'NO') ? 'checked' : ''; ?>>NO
                </div>

            </div>
            <button type="update" class="btn btn-success" name="update">UPDATE</button>

        </form>

    </div>
    <script>
        var map = L.map('map').setView([10.7335, 122.5557], 16); // Coordinates for Barangay Tabuc Suba
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker;

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
                   document.getElementById('presentAdd').value = data.display_name;
               })
               .catch(error => console.error('Error:', error));
       }

       map.on('click', onMapClick);

    </script>
    <br>

</body>

</html>