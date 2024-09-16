<!DOCTYPE html>
<html lang="en">

<head>
    <title>Families</title>
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
                <label><span style="color:black; font-size: 20px">Search Family ID#</span> </label>
                <input class="form-control mr-sm-2 ml-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-light mr-sm-2" type="submit" style="background-color: #E1D7B7; color: black;">Search</button>
                <select name="sort" class="form-control mr-sm-2">
                    <option value="">Sort By</option>
                    <option value="family_members">Number of Family Members</option>
                    <option value="pwd_status">PWD Status</option>
                    <option value="unregistered">Unregistered Families</option>
                    <option value="evacuated">Evacuated Families</option>
                </select>
                <button class="btn btn-light" type="submit" style="background-color: #E1D7B7; color: black;">Sort</button>
            </form>
            <br>
            <div class="table-wrapper">
                <form>
                    <table class="table table-hover table-bordered table-light">
                        <thead>
                            <tr>
                                <th scope="col">Family ID#</th>
                                <th scope="col">Present Address</th>
                                <th scope="col">Number of Members</th>
                                <th scope="col">Number of PWD</th>
                                <th scope="col">Evacuation Center #</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">View Family</th>
                                <th scope="col">REGISTER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'db.php';

                            $search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
                            $sort_column = isset($_GET['sort']) ? mysqli_real_escape_string($conn, $_GET['sort']) : '';
                            $sort_order = 'DESC';

                            $sql = "
                                SELECT 
                                     f.family_id,
                                        f.presentAddress,
                                        f.latitude,
                                        f.longitude,
                                        COUNT(r.residentID) AS num_members,
                                        SUM(CASE WHEN r.PWD = 'YES' THEN 1 ELSE 0 END) AS num_pwd,
                                        f.evacID
                                    FROM tbl_families f
                                    LEFT JOIN tbl_residents r ON f.family_id = r.family_id
                                    WHERE 
                                        f.family_id LIKE '%$search_query%'
                                        OR f.presentAddress LIKE '%$search_query%' 
                                        OR r.lastName LIKE '%$search_query%' 
                                        OR r.firstName LIKE '%$search_query%'
                                    GROUP BY f.family_id
                                ";

                            // Add sorting to SQL query
                            if ($sort_column) {
                                if ($sort_column == 'family_members') {
                                    $sql .= " ORDER BY num_members $sort_order";
                                } elseif ($sort_column == 'pwd_status') {
                                    $sql .= " ORDER BY num_pwd $sort_order";
                                } elseif ($sort_column == 'unregistered') {
                                    // Sort by families who are not evacuated (evacID is NULL or 0) using CASE statement
                                    $sql .= " ORDER BY (CASE WHEN f.evacID IS NULL OR f.evacID = 0 THEN 1 ELSE 0 END) DESC, num_members $sort_order";
                                }
                                } elseif ($sort_column == 'evacuated') {
                                    // Sort by families who are not evacuated (evacID is NULL or 0) using CASE statement
                                    $sql .= " ORDER BY (CASE WHEN f.evacID > 0 THEN 1 ELSE 0 END) DESC, num_members $sort_order";
                            }

                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $family_id = $row['family_id'];
                                    $presentAddress = $row['presentAddress'];
                                    $num_members = $row['num_members'];
                                    $num_pwd = $row['num_pwd'];
                                    $latitude = $row['latitude'];
                                    $longitude = $row['longitude'];
                                    $evacID = $row['evacID'];

                                    // Check if family is registered
                                    $evacStatus = $evacID && $evacID != 0 ? "<span style='color: green;'>Evacuated</span>" : "<span style='color: red;'>Not Evacuated</span>";

                                    echo '<tr>
                                        <th scope="row">' . $family_id . '</th>
                                        <td>' . $presentAddress . '</td>
                                        <td>' . $num_members . '</td>
                                        <td>' . $num_pwd . '</td>
                                        <td>' . $evacID . '</td>
                                        <td>' . $evacStatus . '</td>
                                        <td>
                                            <button class="btn btn-success">
                                                <a href="displayResidents.php?family_id=' . $family_id . '" class="text-light">VIEW</a>
                                            </button>
                                        </td>
                                        <td>
                                            <!-- Register button for nearest evac center -->
                                            <form action="evacSite.php" method="GET">
                                                <input type="hidden" name="family_id" value="' . $family_id . '">
                                                <input type="hidden" name="latitude" value="' . $latitude . '">
                                                <input type="hidden" name="longitude" value="' . $longitude . '">
                                                <button class="btn btn-primary" type="submit">Register</button>
                                            </form>
                                        </td>
                                    </tr>';
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No records found</td></tr>";
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