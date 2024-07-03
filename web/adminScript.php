<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>
<script type="text/javascript">
  function submitData(){
    $(document).ready(function(){
      var data = {
        username: $("#username").val(),
        password: $("#password").val(),
        action: $("#action").val(),
      };

      $.ajax({
        url: 'adminFunction.php',
        type: 'post',
        data: data,
        success:function(response){
          if (response == "Admin Login Successful") {
            showNotification('notification', 'Login Successful');
            setTimeout(function () {
              window.location.reload();
            }, 1500); // Redirect after 3 seconds
          } else {
            showNotification('errorNotification', 'Incorrect Username or Password');
          }
        }
      });
      function showNotification(id, message) {
    const notification = document.getElementById(id);
    notification.innerHTML = message;
    notification.style.display = 'block';
    setTimeout(function () {
      notification.style.display = 'none';
    }, 2500); // Hide after 3 seconds
  }
    });
  }
</script>
