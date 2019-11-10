<?php
require 'config/config.php';
require 'form_handlers/register_handler.php';
require 'form_handlers/login_handler.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome to GradeGoal</title>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">

  	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>
<body>

<?php if(isset($_POST['register_button'])) { //Opens the modal after submission ?>
    <script>
        $(document).ready(function() {
            $('#modal_register').modal('show')
        });
    </script>
<?php } ?>

<nav class="navbar navbar-expand-sm" data-toggle="affix">
	<div class="login">
		<form action="register" method="POST">
			<input type="email" name="log_email" placeholder="Email" value="<?php if(isset($_SESSION['log_email'])) {
				echo $_SESSION['log_email'];
			} ?>" required>
			<input type="password" name="log_password" placeholder="Password" required>
			<input type="submit" name="login_button" value="Log In">
			<br>
			<?php
				if(in_array("Email or password was incorrect<br>", $error_array))
					echo "<p class='error_message' style='width: 250px; text-align: center; float: left;'>Email or password was incorrect</p><br><br>";
			?>
		</form>
		<div class="bottom_form">
			<p>New to GradeGoal? <a data-toggle="modal" data-target="#modal_register" style="color: #546de5; font-size: 15px;">Join now</a></p><a href="requestReset">Forgot Password?</a>
		</div>
	</div>
</nav>

<div id="title_logo">
    <a href="register"><img src="assets/images/logo.png" onContextMenu="return false;"></a><br>
    <h3>GradeGoal</h3>
</div>

<hr>

<nav class="navbar navbar-expand-sm" data-toggle="affix">
    <div class="mx-auto d-sm-flex d-block flex-sm-nowrap">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation" style="margin-left: 200px;">
          <span class="navbar-toggler-icon" style="">   
              <i class="fas fa-bars" style="color:#000; font-size:28px;"></i>
          </span>
        </button>
        <div class="collapse navbar-collapse text-center" id="navbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="register">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calculator">Calculator</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#modal_register" style="cursor: pointer;">Sign Up</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="modal_register" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sign up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="register" method="POST" class="register_form">
			<input type="text" name="reg_fname" placeholder="First Name" value="<?php if(isset($_SESSION['reg_fname'])) {
				echo $_SESSION['reg_fname'];
			} ?>" required>
			<input type="text" name="reg_lname" placeholder="Last Name" value="<?php if(isset($_SESSION['reg_lname'])) {
				echo $_SESSION['reg_lname'];
			} ?>" required>
			<?php
				if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array))
					echo "<p class='error_message' style='text-align: center; float:left; display:inline;'>Your first name must be between 2 and 25 characters</p>";
			?>
			<?php
				if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array))
					echo "<p class='error_message' style='text-align: center; float:right; display:inline;'>Your last name must be between 2 and 25 characters</p>";
			?>
			<br>
			<input type="email" name="reg_email" placeholder="Email" value="<?php if(isset($_SESSION['reg_email'])) {
				echo $_SESSION['reg_email'];
			} ?>" required>
			<br>
			<?php
				if(in_array("Email already in use<br>", $error_array))
					echo "<p class='error_message' style='text-align: center; float: left;'>Email already in use<br></p>";
			
				else if(in_array("Invalid email format<br>", $error_array))
					echo "<p class='error_message' style='text-align: center; float: left;'>Invalid email format<br></p>";
			?>
			<input type="password" name="reg_password" placeholder="Password" required>
			<br>
			<input type="password" name="reg_password2" placeholder="Confirm Password" required>
			<br>
			<?php
				if(in_array("Your passwords do not match<br>", $error_array))
					echo "<p class='error_message' style='text-align: center; float: left;'>Your passwords do not match<br></p><br><br>";
			
				else if(in_array("Your password can only contain english characters or numbers<br>", $error_array))
					echo "<p class='error_message' style='text-align: center; float: left; font-size:15px;'>Your password can only contain english characters or numbers<br></p><br><br><br>";

				else if(in_array("Your password must be between 5 and 30 characters<br>", $error_array))
					echo "<p class='error_message' style='text-align: center; float: left;'>Your password must be between 5 and 30 characters<br></p><br><br><br>";
			?>
			<input type="number" step="any" min="0" max="4" name="reg_gpa" placeholder="GPA, Ex: 3.6" id="gpa_input" autocomplete="off" onkeypress="return isNumberKey(event)" style="display: none;">
			<input type="checkbox" name="txtCheck" id="gpa_checkbox" onclick="gpaCheck()" <?php if(isset($_POST['txtCheck'])) echo "checked='checked'"; ?> >
			<label for="gpa_checkbox">Would you like us to keep track of your GPA?</label>
			<br>
			<?php
				if(in_array("GPA must be a number between 0 and 4<br>", $error_array))
					echo "<p class='error_message' style='text-align: center; float: left;'>GPA must be a number between 0 and 4<br></p><br><br><br>";
			?>
			<input type="submit" name="register_button" class="btn btn-primary" value="Sign up">
			<br>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
	let checkBox = document.getElementById("gpa_checkbox")
	let gpa_input = document.getElementById("gpa_input")
	if (checkBox.checked == true){
    	gpa_input.style.display = "block"
  	}
</script>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script defer src="assets/js/script.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap.bundle.js"></script>

</body>
</html>