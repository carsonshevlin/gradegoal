<?php
include("includes/header.php");

if(isset($_POST['cancel'])) {
	header("Location: settings");
}

if(isset($_POST['close_account'])) {
	$close_query = mysqli_query($con, "UPDATE users SET user_closed='yes' WHERE username='$userLoggedIn'");
	session_destroy();
	header("Location: register");

}
?>
<title>GradeGoal | Close Account</title>
<div class="container-fluid close_account_box">
	<div class="text-center container settings_box" style="margin-top: 75px;">
		<div class="settings_info_box">
			<h4>Close Account</h4>

			<p>Are you sure you want to close your account?</p><br>
			<p>Closing your account will hide your profile and all your activity.</p><br>
			<p>You can re-open your account at any time by simply logging in.</p><br><br>

			<form action="close_account" method="POST">

				<input type="submit" name="close_account" id="close_account" value="Close">
				<input type="submit" name="cancel" id="update_details" value="Cancel">
				
			</form>
		</div>
	</div>
</div>

<?php include("includes/footer.php"); ?>