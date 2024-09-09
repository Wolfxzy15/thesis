<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>
<script type="text/javascript">
  function submitData() {
    $(document).ready(function() {
      var data = {
        username: $("#username").val(),
        password: $("#password").val(),
        action: $("#action").val(),
      };

      $.ajax({
        url: 'adminFunction.php',
        type: 'post',
        data: data,
        success: function(response) {
          if (response.trim() == "Admin Login Successful") {
            Swal.fire({
              icon: 'success',
              title: 'Login Successful',
              ConfirmButton: "OK",
            }).then(() => {
              window.location.href = 'RESIDENTREGISTER.php';
            });
          }else if (response.trim() == "Admin Registration Successful") {  //ADMIN REGISTRATION PART
            Swal.fire({
              icon: 'success',
              title: 'Admin Registered Successfully',
              ConfirmButton: "OK",
            }).then(() => {
              window.location.reload();
            });
          }else if (response.trim() == "Username Has Already Taken") {
            Swal.fire({
              icon: 'warning',
              title: 'Username Has Already Taken',
              ConfirmButton: "OK",
            });
          }else if (response.trim() == "Wrong Password") {
            Swal.fire({
              icon: 'warning',
              title: 'Wrong Password',
              ConfirmButton: "OK",
            });
          }else if (response.trim() == "Admin Not Registered") {
            Swal.fire({
              icon: 'warning',
              title: 'Admin Not Registered',
              ConfirmButton: "OK",
            });
          }
          else {
            Swal.fire({ 
              icon: 'error',
              title: 'Error',
              text: response.trim(),
              showConfirmButton: false,
              timer: 2500
            });
          }
        }
      });
    });
  }
</script>