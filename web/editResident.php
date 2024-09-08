<?php
$servername = "localhost"; // or your server
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "barangay1"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['updateID'])) {
    $id = $_GET['updateID'];

    // Fetch resident details
    $sql_resident = "SELECT * FROM tbl_residents WHERE residentID=$id";
    $result_resident = mysqli_query($conn, $sql_resident);
    if ($result_resident && mysqli_num_rows($result_resident) > 0) {
        $row_resident = mysqli_fetch_assoc($result_resident);

        // Assigning the values to be used in the form
        $family_id = $row_resident['family_id'];
        $lastName = $row_resident['lastName'];
        $firstName = $row_resident['firstName'];
        $middleName = $row_resident['middleName'];
        $age = $row_resident['age'];
        $kinship = $row_resident['kinship'];
        $sex = $row_resident['sex'];
        $civilStatus = $row_resident['civilStatus'];
        $dateOfBirth = $row_resident['dateOfBirth'];
        $placeOfBirth = $row_resident['placeOfBirth'];
        $height = $row_resident['height'];
        $weight = $row_resident['weight'];
        $contactNo = $row_resident['contactNo'];
        $religion = $row_resident['religion'];
        $email = $row_resident['email'];
        $pwd = $row_resident['pwd'];
    } else {
        die("No resident found with ID: $id");
    }
} else {
    die("Update ID is not set.");
}

if (isset($_POST["update"])) {
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $age = $_POST['age'];
    $kinship = $_POST['kinship'];
    $sex = $_POST['sex'];
    $civilStatus = $_POST['civilStatus'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $placeOfBirth = $_POST['placeOfBirth'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $contactNo = $_POST['contactNo'];
    $religion = $_POST['religion'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];


    if (
        empty($kinship) || empty($lastName) || empty($firstName) || empty($middleName) || empty($age) || empty($civilStatus) ||
        empty($dateOfBirth) || empty($placeOfBirth) || empty($height) || empty($weight) || empty($contactNo) || empty($religion) ||
        empty($email) || empty($pwd)
    ) {
        $message = 'incomplete';
    } else {

        $sql_resident_update = "UPDATE tbl_residents SET 
            lastName = '$lastName', firstName = '$firstName', middleName = '$middleName', age = '$age', 
            kinship = '$kinship', sex = '$sex', civilStatus = '$civilStatus', 
            dateOfBirth = '$dateOfBirth', placeOfBirth = '$placeOfBirth', height = '$height', 
            weight = '$weight', contactNo = '$contactNo', religion = '$religion', email = '$email', 
            pwd = '$pwd'
            WHERE residentID = $id";

        $result_resident_update = mysqli_query($conn, $sql_resident_update);

        // Optionally, update family information if needed
        // $sql_family_update = "UPDATE tbl_families SET ... WHERE family_id = $family_id";
        // $result_family_update = mysqli_query($conn, $sql_family_update);

        if ($result_resident_update) {
            $message = 'success';
        } else {
            $message = 'error';
        }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <?php include 'include/sidebar.php'; ?>
    <main>
        <div class="container" style="background-color: aliceblue; border-radius: 5px; padding: 12px; margin: auto;">
            <form autocomplete="off" action="" method="post">
                <input type="hidden" id="action" value="register">
                <h2 style="text-align: center;">Update Information</h2>
                <h3 style="text-align: left;">Family ID#: <?php echo $family_id; ?></h3>
                <hr>
                <div class="row row-cols-2 mb-3">
                    <div class="col-md-4 mb-2">
                        <label for="lastName">Lastname:</label>
                        <input type="text" class="form-control" value="<?php echo $lastName; ?>" placeholder="Last name" id="lastName" name="lastName">
                    </div>
                    <div class="col-md-4">
                        <label for="firstName">Firstname:</label>
                        <input type="text" class="form-control" value="<?php echo $firstName; ?>" placeholder="First name" id="firstName" name="firstName">
                    </div>
                    <div class="col-md-4">
                        <label for="middleName">Middlename:</label>
                        <input type="text" class="form-control" value="<?php echo $middleName; ?>" placeholder="Middle name" id="middleName" name="middleName">
                    </div>
                    <div class="col-md-4 mb-2">
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
                    <div class="col-md-2 mb-2">
                        <label for="sex">Sex:</label>
                        <div>
                            <input type="radio" value="Female" id="female" name="sex" <?php echo ($sex == 'Female') ? 'checked' : ''; ?>>Female
                        </div>
                        <div>
                            <input type="radio" value="Male" id="male" name="sex" <?php echo ($sex == 'Male') ? 'checked' : ''; ?>>Male
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="civilStatus">Civil Status:</label>
                        <select id="civilStatus" name="civilStatus" class="form-control">
                            <option value="">--Status--</option>
                            <option value="Single" <?php echo ($civilStatus == 'Single') ? 'selected' : ''; ?>>Single</option>
                            <option value="Married" <?php echo ($civilStatus == 'Married') ? 'selected' : ''; ?>>Married</option>
                            <option value="Widowed" <?php echo ($civilStatus == 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
                            <option value="Separated" <?php echo ($civilStatus == 'Separated') ? 'selected' : ''; ?>>Separated</option>

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
                <div class="row row-cols-2 mb-3">
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
                        <label for="email">Email Address:</label>
                        <input type="text" class="form-control" value="<?php echo $email; ?>" placeholder="@email.com" id="email" name="email">
                    </div>
                    <div class="col-md-4">
                        <label for="pwd">Are you a person with disability?</label>
                        <div>   
                        <input type="radio" value="YES" id="yes" name="pwd" <?php echo ($pwd == 'YES') ? 'checked' : ''; ?>>YES
                        </div>
                        <div>
                        <input type="radio" value="NO" id="no" name="pwd" <?php echo ($pwd == 'NO') ? 'checked' : ''; ?>>NO
                        </div>
                    </div>
                </div>
                <button type="update" class="btn btn-success" name="update" style="width: 100%;">UPDATE</button>
            </form>
        </div>
    </main>
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
                text: 'Resident information updated successfully!',
                confirmButtonText: 'OK'
            });
        <?php elseif ($message == 'error'): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'There was an error updating the resident information.',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    </script>

</body>

</html>