<?php 
include("includes/header.php");
include("includes/form_handlers/settings_handler.php");

$user_data_query = "SELECT first_name, last_name, email, gpa FROM users WHERE username=?";

$stmt = mysqli_stmt_init($con);

if(!mysqli_stmt_prepare($stmt, $user_data_query)) {
    echo "Error";
}
else {
  mysqli_stmt_bind_param($stmt, "s", $userLoggedIn);

  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

}

$row = mysqli_fetch_array($result);

$first_name = $row['first_name'];
$last_name = $row['last_name'];
$email = $row['email'];

if($row['gpa'] == "NA") {
	$gpa = "";
	$gpa_label_message = "Want us to track your GPA?";
}
else {
	$gpa = number_format($row['gpa'], 2);
	$gpa_label_message = "<b>**This will not update your overall GPA, only the GPA you started with**</b><br>GPA:";
}

?>
<title>GradeGoal | Settings</title>
<div class="container-fluid settings_page">
		<div class="text-center">
			<h3>Account Settings</h3>
		</div>
		<div class="container settings_box">
			<div class="settings_info_box">
		      <h4>Change Personal Info</h4>
		      <form action="settings" method="POST" class="settings_input">
		        <label>First Name: </label><br><input type="text" name="first_name" value="<?php echo $first_name; ?>" autocomplete="off" required><br>
		        <label>Last Name: </label><br><input type="text" name="last_name" value="<?php echo $last_name; ?>" autocomplete="off" required><br>
		        <label>Email: </label><br><input type="text" name="email" value="<?php echo $email; ?>" autocomplete="off" required><br><br>

		        <?php echo $message;?><br>

		        <input type="submit" name="update_details" id="save_details" value="Update Details"><br>
		      </form>
	    	</div>

	    	<div class="change_password_box">
		      <h4>Change Password</h4>
		      <form action="settings" method="POST" class="settings_input">
		        <label>Old Password: </label><br><input type="password" name="old_password" required><br>
		        <label>New Password: </label><br><input type="password" name="new_password_1" required><br>
		        <label>New Password Again: </label><br><input type="password" name="new_password_2" required><br><br>

		        <?php echo $password_message;?><br>

		        <input type="submit" name="update_password" id="save_details" value="Update Password"><br>
		      </form>
	  		</div>

	  		<div class="gpa_info_box">
		      <h4>Update GPA</h4>
		      <form action="settings" method="POST" class="settings_input">
		        <label><?php echo $gpa_label_message; ?></label><br><input type="number" min="0" max="4" step="any" name="gpa" value="<?php echo $gpa; ?>" required><br><br>

		        <?php echo $gpa_message;?>

		        <input type="submit" name="update_gpa" id="save_details" value="Update"><br>
		      </form>
	  		</div>
	  	</div>
	    <div class="text-center close_account">
	      <h4>Close Account</h4>
	      <a href="close_account">Close Account</a>
	    </div>
</div>

<?php include("includes/footer.php"); ?>