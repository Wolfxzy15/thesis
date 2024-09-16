<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
  <style>
    body{
      background-color: #7C93C3;
    }
    .center-image {
      display: flex;
      justify-content: center;
    }
    .navbar{
      background-color:#1E2A5E;
    }
    .navbar a{
      color: aliceblue;
      font-size: 25px;
    }
    .navbar li{
      font-size: 15px;
    }
  </style>
</head>

<body>
<nav class="navbar">
  <a class="navbar-brand" href="#">
    <img src="images/citylogo.png" width="40" height="40" class="d-inline-block align-top" alt="">
    Barangay
  </a>
</nav>
  <div class="container mt-5 pt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <div class="center-image">
              <img src="images/citylogo.png"
                width="90" height="90" alt="">
            </div>
            <h2 style="text-align: center;">Administrator Registration</h2>
          </div>
          <div class="card-body">
            <form autocomplete="off" action="" method="post">
              <input type="hidden" id="action" value="register">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Register Username" name="username" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Register Password" name="password" required>
              </div>
              <button type="button" onclick="submitData();" class="btn btn-success" style="width: 100%">Register</button>
              <br><br>
              <p class="mb-0">Already have an account? <a href="adminLogin.php">Login here</a>.</p>
            </form>

            <?php require 'adminScript.php'; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
  </script>


</body>

</html>

