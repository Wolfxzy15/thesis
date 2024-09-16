<!DOCTYPE html>
<html lang="en">

<head>
    <title>Display Residents</title>
    <link rel="icon" type="image/x-icon" href="./assets/favicon.ico" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
</head>

<body>

    <?php include 'include/sidebar.php'; ?>
    <main>
        <div class="table-container">
            <form class="form-inline mx-auto" method="GET" action="">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-light mr-sm-2" type="submit" style="background-color: #E1D7B7; color: black;">Search</button>
                <select name="sort" class="form-control mr-sm-2">
                    <option value="">Sort By</option>
                    <option value="pwd">PWD Status</option>
                </select>
                <button class="btn btn-light" type="submit" style="background-color: #E1D7B7; color: black;">Sort</button>
            </form>
            <br>
            <div class="table-wrapper">
                <form>
                    <table class="table table-hover table-bordered table-light">
                        <thead>
                            <tr>
                                <th scope="col">Resident ID</th>
                                <th scope="col">Family ID</th>
                                <th scope="col">Lastname</th>
                                <th scope="col">Firstname</th>
                                <th scope="col">Age</th>
                                <th scope="col">Sex</th>
                                <th scope="col">PWD</th>
                                <th scope="col">Evacuation Status</th>
                                <th scope="col">EDIT Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'db.php';
                            $family_id = isset($_GET['family_id']) ? intval($_GET['family_id']) : 0;

                            $search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
                            $sort_column = isset($_GET['sort']) ? mysqli_real_escape_string($conn, $_GET['sort']) : '';
                            $sort_order = 'ASC';

                            $sql = "SELECT r.*, f.evacID 
                                    FROM tbl_residents r 
                                    LEFT JOIN tbl_families f ON r.family_id = f.family_id";

                            if ($family_id > 0) {
                                $sql .= " WHERE r.family_id = $family_id";
                            } else if (is_numeric($search_query)) {
                                $sql .= " WHERE r.family_id = '$search_query'";
                            } else {
                                $sql .= " WHERE 
                                    r.residentID LIKE '%$search_query%' OR 
                                    r.kinship LIKE '%$search_query%' OR 
                                    r.lastName LIKE '%$search_query%' OR 
                                    r.firstName LIKE '%$search_query%' OR 
                                    r.age LIKE '%$search_query%' OR 
                                    r.sex LIKE '%$search_query%' OR   
                                    r.pwd LIKE '%$search_query%'";
                            }

                            if ($sort_column) {
                                if ($sort_column == 'pwd') {
                                    $sql .= " ORDER BY r.pwd = 'NO', r.pwd $sort_order";
                                } else {
                                    $sql .= " ORDER BY $sort_column $sort_order";
                                }
                            }

                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['residentID'];
                                    $family_id = $row['family_id'];
                                    $lastName = $row['lastName'];
                                    $fName = $row['firstName'];
                                    $age = $row['age'];
                                    $sex = $row['sex'];
                                    $pwd = $row['pwd'];

                                    $evacStatus = ($row['evacID'] && $row['evacID'] != 0) 
                                        ? "<span style='color: green;'>Evacuated</span>" 
                                        : "<span style='color: red;'>Not Evacuated</span>";

                                    echo '<tr>
                                        <th scope="row">' . $id . '</th>
                                        <td>' . $family_id . '</td>
                                        <td>' . $lastName . '</td>
                                        <td>' . $fName . '</td>
                                        <td>' . $age . '</td>
                                        <td>' . $sex . '</td>
                                        <td>' . $pwd . '</td>
                                        <td>' . $evacStatus . '</td>
                                        <td>
                                            <button class="btn btn-success">
                                                <a href="editResident.php?updateID=' . urlencode($id) . '" class="text-light">EDIT</a>
                                            </button>
                                        </td>
                                    </tr>';
                                }
                            } else {
                                echo "<tr><td colspan='9' class='text-center'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>
