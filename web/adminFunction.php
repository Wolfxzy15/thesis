<?php
session_start();

include 'include/db.php';

// IF
if(isset($_POST["action"])){
  if($_POST["action"] == "register"){
    adminPage();
  }
  else if($_POST["action"] == "adminlogin"){
    adminlogin();
  }
}

// REGISTER ADMIN
function adminPage(){
  global $conn;

  $username = $_POST["username"];
  $password = $_POST["password"];

  if(empty($username) || empty($password)){
    echo "Please Fill Out The Form!";
    exit;
  }

  $user = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE username = '$username'");
  if(mysqli_num_rows($user) > 0){
    echo "Username Has Already Taken";
    exit;
  }

  $query = "INSERT INTO tbl_admin (username, password) VALUES('$username', '$password')";
  mysqli_query($conn, $query);
  echo "Admin Registration Successful";
}

// LOGIN ADMIN
function adminlogin(){
  global $conn;

  $username = $_POST["username"];
  $password = $_POST["password"];

  $user = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE username = '$username'");

  if(mysqli_num_rows($user) > 0){

    $row = mysqli_fetch_assoc($user);

    if($password == $row['password']){
      echo "Admin Login Successful";
      $_SESSION["login"] = true;
      $_SESSION["adminID"] = $row["adminID"];
    }
    else{
      echo "Wrong Password";
      exit;
    }
  }
  else{
    echo "Admin Not Registered";
    exit;
  }
}
?>
