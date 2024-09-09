<?php include 'include/sidebar.php'; 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evacuation Center</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #map {border: aliceblue solid; width: 1000px; height: 300px; margin-top: 100px; display: grid;}

        body {
            justify-content: center;
            display: grid;
        }

        #inputbox {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 1000px;
            margin: 10px 0;
        }

        input.readonly-input {
            width: 32%;
            margin: 0;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            /* display: none; */
        }

        #unreg{
            width: 100%;
            position: relative;
            background-color: #55679C;
            font-family: Arial, Helvetica, sans-serif;
            margin-top: 30px;
            justify-content: center;
            border-radius: 5px;
        }

        p {
            color: white;
        }

    </style>
</head>
<body>
    <div id='map'></div>
    <form action="" method="post">
    <div id="inputbox">
        
        <input type="text" id="evac1" name="evac1" class="readonly-input" readonly placeholder="Evacuation Center 1 distance">
        <input type="text" id="evac2" name="evac2" class="readonly-input" readonly placeholder="Evacuation Center 2 distance">
        <input type="text" id="evac3" name="evac3" class="readonly-input" readonly placeholder="Evacuation Center 3 distance">
        
    </div>
    <button type="submit" class="btn btn-primary" name="register" style="justify-content: center;">Register</button>
    </form>
    <div id="text">
        <p id="mindistance"></p>
    </div>

    <div id="unreg">
        <p>Unregistered</p>
    </div>

    <table class="table table-hover table-bordered table-light">
        <thead>
            <tr>
                <th scope="col">Family ID#</th> 
                <th scope="col">Number of Members</th>
                <th scope="col">Number of PWD</th>
                <th scope="col">View Location</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include 'db.php';

                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                    if (isset($_POST['view'])){
                        $lat = $_POST['latitude'];
                        $long = $_POST['longitude'];
                        $famID = $_POST['familyid'];
                        $_SESSION['famID'] = $famID;
                    }
                    

                } 

                
                $sql = "SELECT * FROM tbl_families WHERE evacID = 1";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)){
                        $family_id = $row['family_id'];
                        $num_members = $row['num_members'];
                        $num_pwd = $row['num_pwd'];
                        $latitude = $row['latitude'];
                        $longitude = $row['longitude'];

                        echo '<tr>
                            <form method="POST">
                                <input type="hidden" name="latitude" value="' . $latitude .'">
                                <input type="hidden" name="longitude" value="' . $longitude . '">
                                <input type="hidden" name="familyid" value="' . $family_id . '">
                                <th scope="row">'. $family_id .'</th>
                                <td>'.$num_members.'</td>
                                <td>'.$num_pwd.'</td>
                                <td><button type="submit" class="btn btn-success" name="view">View</button></td>
                            </form></tr>';
                    }
                }

            ?>
        </tbody>
    </table>
    <?php include 'mapFunction.php'; 
    include 'tables.php';
    ?>
    
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    include 'db.php'; // Ensure the database connection is included

    // Retrieve familyID from session
    $familyID = isset($_SESSION['famID']) ? intval($_SESSION['famID']) : null;
    echo $familyID;

    if ($familyID) {
        // Retrieve and sanitize evacuation distances
        $evacuation1 = isset($_POST['evac1']) ? (int)$_POST['evac1'] : 0;
        $evacuation2 = isset($_POST['evac2']) ? (int)$_POST['evac2'] : 0;
        $evacuation3 = isset($_POST['evac3']) ? (int)$_POST['evac3'] : 0;

        // Find the minimum evacuation distance
        $nevacuation = array($evacuation1, $evacuation2, $evacuation3);
        sort($nevacuation);
            
        include 'count.php';

        // Update database if the minimum distance matches
if ($nevacuation[0] == $evacuation1) {
    if ($countc1['count1'] < 5) { // Note the use of '==' for comparison
        $sql = "UPDATE tbl_families SET evacID = 2 WHERE family_id = $familyID";
        $result = mysqli_query($conn, $sql);
    } else if ($nevacuation[1] == $evacuation2) {
        if ($countc2['count2'] < 5) { // Note the use of '==' for comparison
            $sql = "UPDATE tbl_families SET evacID = 3 WHERE family_id = $familyID";
            $result = mysqli_query($conn, $sql);
        } else if ($nevacuation[2] == $evacuation3) {
            if ($countc3['count3'] < 5) {
                $sql = "UPDATE tbl_families SET evacID = 4 WHERE family_id = $familyID";
                $result = mysqli_query($conn, $sql);
            }
        }
    }
} else if ($nevacuation[0] == $evacuation2) {
    if ($countc2['count2'] < 5) { // Note the use of '==' for comparison
        $sql = "UPDATE tbl_families SET evacID = 3 WHERE family_id = $familyID";
        $result = mysqli_query($conn, $sql);
    } else if ($nevacuation[1] == $evacuation1) {
        if ($countc1['count1'] < 5) { // Note the use of '==' for comparison
            $sql = "UPDATE tbl_families SET evacID = 2 WHERE family_id = $familyID";
            $result = mysqli_query($conn, $sql);
        } else if ($nevacuation[2] == $evacuation3) {
            if ($countc3['count3'] < 5) {
                $sql = "UPDATE tbl_families SET evacID = 4 WHERE family_id = $familyID";
                $result = mysqli_query($conn, $sql);
            }
        }
    } else if ($nevacuation[1] == $evacuation3) {
        if ($countc3['count3'] < 5) {
            $sql = "UPDATE tbl_families SET evacID = 4 WHERE family_id = $familyID";
            $result = mysqli_query($conn, $sql);
        } else if ($nevacuation[2] == $evacuation1) {
            if ($countc1['count1'] < 5) { // Note the use of '==' for comparison
                $sql = "UPDATE tbl_families SET evacID = 2 WHERE family_id = $familyID";
                $result = mysqli_query($conn, $sql);
            }
        }
    }
} else if ($nevacuation[0] == $evacuation3) {
    if ($countc3['count3'] < 5) {
        $sql = "UPDATE tbl_families SET evacID = 4 WHERE family_id = $familyID";
        $result = mysqli_query($conn, $sql);
    } else if ($nevacuation[1] == $evacuation1) {
        if ($countc1['count1'] < 5) { // Note the use of '==' for comparison
            $sql = "UPDATE tbl_families SET evacID = 2 WHERE family_id = $familyID";
            $result = mysqli_query($conn, $sql);
        } else if ($nevacuation[2] == $evacuation2) {
            if ($countc2['count2'] < 5) { // Note the use of '==' for comparison
                $sql = "UPDATE tbl_families SET evacID = 3 WHERE family_id = $familyID";
                $result = mysqli_query($conn, $sql);
            }
        }
    }
} else {
    echo "All evacuation centers are full";
}


    mysqli_close($conn); // Ensure the database connection is closed
    }}
?>
