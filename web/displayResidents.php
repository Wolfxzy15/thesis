<?php
session_start();

if(isset($_POST['register'])){
    $id = $_POST['register']; // Capture the residentID from the button value
    $_SESSION['residentID'] = $id;
    header("Location: js.php"); // Redirect to js.php to use the session variable
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Index</title>
    <link rel="icon" type="image/x-icon" href="./assets/favicon.ico" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <style>
        .table-container {
            margin-left: 20px;
            margin-right: 20px;
        }
    </style>
</head>
<body style="background-image: url('https://dynamic-media-cdn.tripadvisor.com/media/photo-o/06/e0/4c/2d/iloilo-city-hall.jpg?w=1200&h=-1&s=1'); background-repeat: no-repeat; background-size: cover;">

    <?php include 'include/nav.php';?>

    <div class="table-container">
        <form class="form-inline mx-auto" method="GET" action="">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success mr-sm-8" type="submit">Search</button>
            <select name="sort" class="form-control ml-2">
                <option value="">Sort By</option>
                <option value="age">Age</option>
                <option value="lastName">Last Name</option>
                <option value="fName">First Name</option>
                <option value="famComposition">Family Composition</option>
                <option value="pwd">PWD</option>
            </select>
            <button class="btn btn-outline-success ml-2" type="submit">Sort</button>
        </form>
        <br>
        <form method="POST" action="">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Kinship</th>
                        <th scope="col">Lastname</th>
                        <th scope="col">Firstname</th>
                        <th scope="col">Age</th>
                        <th scope="col">Sex</th>
                        <th scope="col">Present Address</th>
                        <th scope="col">Provincial Address</th>
                        <th scope="col">Civil Status</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Place of Birth</th>
                        <th scope="col">Height</th>
                        <th scope="col">Weight</th>
                        <th scope="col">Contact #</th>
                        <th scope="col">Religion</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">No. of Household Occupants</th>
                        <th scope="col">PWD</th>
                        <th scope="col">Update Information</th>
                        <th scope="col">Evacuation Center</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include 'include/db.php';

                        $search_query = isset($_GET['search']) ? $_GET['search'] : '';
                        $sort_column = isset($_GET['sort']) ? $_GET['sort'] : '';
                        $sort_order = 'ASC';

                        $sql = "SELECT * FROM tbl_residents WHERE 
                                residentID LIKE '%$search_query%' OR 
                                kinship LIKE '%$search_query%' OR 
                                lastName LIKE '%$search_query%' OR 
                                fName LIKE '%$search_query%' OR 
                                age LIKE '%$search_query%' OR 
                                sex LIKE '%$search_query%' OR 
                                presentAdd LIKE '%$search_query%' OR 
                                provAdd LIKE '%$search_query%' OR 
                                civilStat LIKE '%$search_query%' OR 
                                dateOfBirth LIKE '%$search_query%' OR 
                                placeOfBirth LIKE '%$search_query%' OR 
                                height LIKE '%$search_query%' OR 
                                weight LIKE '%$search_query%' OR 
                                contactNo LIKE '%$search_query%' OR 
                                religion LIKE '%$search_query%' OR 
                                emailAdd LIKE '%$search_query%' OR 
                                famComposition LIKE '%$search_query%' OR 
                                pwd LIKE '%$search_query%'";

                        if ($sort_column) {
                            if ($sort_column == 'pwd') {
                                $sql .= " ORDER BY pwd = 'NO', pwd $sort_order";
                            } else {
                                $sql .= " ORDER BY $sort_column $sort_order";
                            }
                        }

                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['residentID'];
                                $kinship = $row['kinship'];
                                $lastName = $row['lastName'];
                                $fName = $row['fName'];
                                $age = $row['age'];
                                $sex = $row['sex'];
                                $presentAdd = $row['presentAdd'];
                                $provAdd = $row['provAdd'];
                                $civilStat = $row['civilStat'];
                                $dateOfBirth = $row['dateOfBirth'];
                                $placeOfBirth = $row['placeOfBirth'];
                                $height = $row['height'];
                                $weight = $row['weight'];
                                $contactNo = $row['contactNo'];
                                $religion = $row['religion'];
                                $emailAdd = $row['emailAdd'];
                                $famComposition = $row['famComposition'];
                                $pwd = $row['pwd'];

                                echo '<tr>
                                    <th scope="row">'.$id.'</th>
                                    <td>'.$kinship.'</td>
                                    <td>'.$lastName.'</td>
                                    <td>'.$fName.'</td>
                                    <td>'.$age.'</td>
                                    <td>'.$sex.'</td>
                                    <td>'.$presentAdd.'</td>
                                    <td>'.$provAdd.'</td>
                                    <td>'.$civilStat.'</td>
                                    <td>'.$dateOfBirth.'</td>
                                    <td>'.$placeOfBirth.'</td>
                                    <td>'.$height.'</td>
                                    <td>'.$weight.'</td>
                                    <td>'.$contactNo.'</td>
                                    <td>'.$religion.'</td>
                                    <td>'.$emailAdd.'</td>
                                    <td>'.$famComposition.'</td>
                                    <td>'.$pwd.'</td>
                                    <td>
                                        <button class="btn btn-success">
                                            <a href="editResident.php?updateID='.$id.'" class="text-light">UPDATE</a>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-success" type="submit" name="register" value="'.$id.'">
                                            Register
                                        </button>
                                    </td>
                                </tr>';
                            }
                        } else {
                            echo "<tr><td colspan='18' class='text-center'>No records found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>
