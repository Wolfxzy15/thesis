<?php

$servername = "localhost"; // Change to your database server name
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "thesis"; // Change to your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $presentAddress = $conn->real_escape_string($_POST['presentAdd']);
    $latitude = $conn->real_escape_string($_POST['latitude']);
    $longitude = $conn->real_escape_string($_POST['longitude']);

    
    $sql_family = "INSERT INTO tbl_families (presentAddress, latitude, longitude) VALUES ('$presentAddress', '$latitude', '$longitude')";
    if ($conn->query($sql_family) === TRUE) {
        $family_id = $conn->insert_id; 
    } else {
        die("Error: " . $sql_family . "<br>" . $conn->error);
    }


    $lastNames = $_POST['lastName'];
    $firstNames = $_POST['fName'];
    $middleNames = $_POST['mName'];
    $ages = $_POST['age'];
    $kinships = $_POST['kinship'];
    $civilStats = $_POST['civilStat'];
    $dateOfBirths = $_POST['dateOfBirth'];
    $placeOfBirths = $_POST['placeOfBirth'];
    $heights = $_POST['height'];
    $weights = $_POST['weight'];
    $contactNos = $_POST['contactNo'];
    $religions = $_POST['religion'];
    $emailAdds = $_POST['emailAdd'];

    for ($i = 0; $i < count($firstNames); $i++) {
        $lname = $lastNames[$i];
        $fname = $firstNames[$i];
        $mname = $middleNames[$i];
        $age = $ages[$i];
        $kin = $kinships[$i];
        $sex = $_POST["sex" . ($i + 1)]; 
        $civil = $civilStats[$i];
        $dob = $dateOfBirths[$i];
        $pob = $placeOfBirths[$i];
        $h = $heights[$i];
        $w = $weights[$i];
        $contact = $contactNos[$i];
        $rel = $religions[$i];
        $email = $emailAdds[$i];
        $pwd = $_POST["pwd" . ($i + 1)]; 

        if (
            empty($kin) || empty($lname) || empty($fname) || empty($mname) || empty($age) || empty($civil) || 
            empty($dob) || empty($pob) || empty($h) || empty($w) || empty($contact) || empty($rel) || 
            empty($email) || empty($pwd)
        ) {
            $message = 'incomplete';
            break; 
        } else {
            $sql_resident = "INSERT INTO tbl_residents 
            (family_id, lastName, firstName, middleName, age, kinship, sex, civilStatus, 
            dateOfBirth, placeOfBirth, height, weight, contactNo, religion, email, PWD) 
            VALUES ('$family_id', '$lname', '$fname', '$mname', '$age', '$kin', '$sex', '$civil', 
            '$dob', '$pob', '$h', '$w', '$contact', '$rel', '$email', '$pwd')";
    
            $result = mysqli_query($conn, $sql_resident);
            if (!$result) {
                $message = 'error';
                break; 
            }
        }
    }
    
    if ($message !== 'incomplete') {
        $message = 'success';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Resident</title>
    <link rel="icon" type="image/x-icon" href="./assets/favicon.ico" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>

<body>
    <?php include 'include/sidebar.php'; ?>
    <main>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let formCount = 0;
                function addForm() {
                    formCount++;
                    const formContainer = document.createElement('div');
                    formContainer.className = 'form-container';
                    formContainer.innerHTML = `
                    <div class="container" style="background-color: aliceblue; border-radius: 5px; padding: 12px; margin: auto;">
                        <h3>Family Member ${formCount}</h3>
                        <div class="row row-cols-2 mb-3">
                            <div class="col-md-4 mb-2">
                                <label for="lastName${formCount}">Lastname:</label>
                                <input type="text" class="form-control" placeholder="Last name" id="lastName${formCount}" name="lastName[]">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="fName${formCount}">Firstname:</label>
                                <input type="text" class="form-control" placeholder="First name" id="fName${formCount}" name="fName[]">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="mName${formCount}">Middlename:</label>
                                <input type="text" class="form-control" placeholder="Middle name" id="mName${formCount}" name="mName[]">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="age${formCount}">Age:</label>
                                <input type="text" class="form-control" placeholder="" id="age${formCount}" name="age[]">
                            </div>
                            <div class="col-md-7 mb-3">
                                <label for="kinship${formCount}">Kinship Position:</label>
                                <select id="kinship${formCount}" name="kinship[]" class="form-control">
                                    <option value="">--Position--</option>
                                    <option value="Head of Family">Head of Family</option>
                                    <option value="Spouse">Spouse</option>
                                    <option value="Solo Parent">Solo Parent</option>
                                    <option value="Solo Living">Solo Living</option>
                                    <option value="Dependent">Dependent</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row row-cols-2 mb-3">
                            <div class="col-md-2 mb-2">
                                <label for="sex${formCount}">Sex:</label>
                                <div>
                                    <input type="radio" value="Female" id="female${formCount}" name="sex${formCount}" required>
                                    <label for="female${formCount}">Female</label>
                                </div>
                                <div>
                                    <input type="radio" value="Male" id="male${formCount}" name="sex${formCount}" required>
                                    <label for="male${formCount}">Male</label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="civilStat${formCount}">Civil Status:</label>
                                <select id="civilStat${formCount}" name="civilStat[]" class="form-control">
                                    <option value="">--Status--</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="dateOfBirth${formCount}">Date Of Birth:</label>
                                <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="dateOfBirth${formCount}" name="dateOfBirth[]">
                            </div>
                            <div class="col-md-4">
                                <label for="placeOfBirth${formCount}">Place Of Birth:</label>
                                <input type="text" class="form-control" placeholder="" id="placeOfBirth${formCount}" name="placeOfBirth[]">
                            </div>
                        </div>
                        <div class="row row-cols-2 mb-3">
                            <div class="col-md-2 mb-2">
                                <label for="height${formCount}">Height:</label>
                                <input type="number" class="form-control" placeholder="cm" id="height${formCount}" name="height[]">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="weight${formCount}">Weight:</label>
                                <input type="number" class="form-control" placeholder="kg" id="weight${formCount}" name="weight[]">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="contactNo${formCount}">Contact Number:</label>
                                <input type="text" class="form-control" placeholder="" id="contactNo${formCount}" name="contactNo[]">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="religion${formCount}">Religion:</label>
                                <input type="text" class="form-control" placeholder="ex.Roman Catholic" id="religion${formCount}" name="religion[]">
                            </div>
                            <div class="col-md-4">
                                <label for="emailAdd${formCount}">Email Address:</label>
                                <input type="text" class="form-control" placeholder="@email.com" id="emailAdd${formCount}" name="emailAdd[]">
                            </div>
                            <div class="col-md-4">
                                <label for="pwd${formCount}">Are you a person with disability?</label>
                                <div>
                                    <input type="radio" value="YES" id="yes${formCount}" name="pwd${formCount}" required>YES
                                    <input type="radio" value="NO" id="no${formCount}" name="pwd${formCount}" required>NO
                                </div>
                            </div>
                        </div>
                    </div><br>
                `;
                    const familyForm = document.getElementById('familyForm');
                    if (familyForm) {
                        familyForm.appendChild(formContainer);
                    } else {
                        console.error('Family form container not found!');
                    }
                }

                // Attach event listener
                document.querySelector('button[onclick="addForm()"]').addEventListener('click', addForm);
            });
        </script>
        <div class="container">
            <form id="familyForm" method="post">
            <h1>Family Registration Form</h1><br>
            <button type="submit" class="btn btn-success" form="familyForm" name="submit">Submit All</button><br><br>
                <label for="presentAdd"><b>Present Address:</b></label><br>
                <div id="map"></div>
                <input type="text" class="form-control" placeholder="Choose from the map" id="presentAdd" name="presentAdd" required readonly>
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude"><br><hr>
                <button onclick="addForm()" class="btn btn-success"><i class="fa-solid fa-user-plus pr-2"></i>Add Family Member</button><br><br>
            </form>
        </div>

    </main>
</body>
<script>
        <?php if ($message == 'incomplete'): ?>
            Swal.fire({
                icon: 'warning',
                title: 'Form Incomplete',
                text: 'Please fill up the form completely!',
                confirmButtonText: 'OK'
            });
        <?php elseif ($message == 'success'): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Family Registered successfully!',
                confirmButtonText: 'OK'
            });
        <?php elseif ($message == 'error'): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'error register resident information.',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    </script>
<script src="script.js"></script>

</html>