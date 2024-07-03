<?php
require 'adminFunction.php';
if(isset($_SESSION["adminID"])){
  header("Location: adminLogin.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Registration Form</title>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Register
                </div>
                <div class="card-body">
                <form autocomplete="off" action="" method="post">
                <input type="hidden" id="action" value="register">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                                </div>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <button type="button" onclick="submitData();" class="btn btn-primary">Register</button>
                    </form>
                    <?php require 'adminScript.php'; ?>
                </div>
                <div class="card-footer">
                    <p class="mb-0">Already have an account? <a href="adminLogin.php">Login here</a>.</p>
                    
                </div>
            </div>
        </div>
    </div>
</div>



</body>
</html>
