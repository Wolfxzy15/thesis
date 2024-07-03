<?php
require 'adminFunction.php';
if(isset($_SESSION["adminID"])){
   header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Electrolize&display=swap" rel="stylesheet">
  <style>
   .center-image {
      display: flex;
      justify-content: center;
    }

    .navbar-brand {
      padding: 0;
    }

    #notification, #errorNotification {
      display: none;
      position: fixed;
      left: 50%;
      top: 12%;
      transform: translate(-50%, -50%);
      width: 80%;
      text-align: center;
      padding: 10px;
      border-radius: 5px;
      z-index: 1000;
    }

    #notification {
      background-color: #28a745;
      color: white;
    }

    #errorNotification {
      background-color: #dc3545;
      color: white;
    }

  </style>
</head>
<body style="background-image: url('https://dynamic-media-cdn.tripadvisor.com/media/photo-o/06/e0/4c/2d/iloilo-city-hall.jpg?w=1200&h=-1&s=1');
  background-repeat: no-repeat;
  background-size: cover;">
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">
    <img src="https://www.clipartmax.com/png/middle/98-987300_seal-of-the-barangay-barangay-logo-png.png" 
    width="85" height="70" class="d-inline-block align-center" alt="">
  </a>
  <h4 style="color: aliceblue;">Barangay</h4>
    <!-- <a class="btn btn-dark ml-auto" href="register.php" role="button">ADMIN</a> --> 
  </div>
</nav><br>
<div id="notification">Login Successful</div>
<div id="errorNotification">Incorrect Username or Password</div>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <div class="center-image">
          <img src="images/admin.png" 
    width="90" height="90" alt="">

          </div>
        
          <h2 style="text-align: center;">Administrator Login</h2>
        </div>  
        <div class="card-body">
        <form autocomplete="off" action="" method="post">
        <input type="hidden" id="action" value="adminlogin">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" placeholder="Admin Username" name="username" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" placeholder="Admin Password" name="password" required>
            </div>
            <button type="button" onclick="submitData();" class="btn btn-dark">Login</button>
            <p class="mb-0">Don't have an account? <a href="register.php">Register here</a>.</p>
          </form>
          
          <?php require 'adminScript.php'; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>


</body>
</html>

