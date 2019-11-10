<?php

if(isset($_POST['update_details'])) {

	$first_name = htmlspecialchars($_POST['first_name'], ENT_QUOTES, 'UTF-8');
	$last_name = htmlspecialchars($_POST['last_name'], ENT_QUOTES, 'UTF-8');
	$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

	$email_check = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
	$row = mysqli_fetch_array($email_check);
	$matched_user = $row['username'];

	if($matched_user == "" || $matched_user == $userLoggedIn) {
		$message = "<p class='success_message' style='float:left;'>Details updated</p><br>";

		$query = "UPDATE users SET first_name=?, last_name=?, email=? WHERE username=?";

		$stmt = mysqli_stmt_init($con);

			if(!mysqli_stmt_prepare($stmt, $query)) {
				echo "Error";
			}
			else {
				mysqli_stmt_bind_param($stmt, "ssss", $first_name, $last_name, $email, $userLoggedIn);

				mysqli_stmt_execute($stmt);

				header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
			}

	}
	else
		$message = "<p class='error_message' style='float:left;'>That email is already in use</p><br>";
}
else
	$message = "";

if(isset($_POST['update_password'])) {

	$old_password = htmlspecialchars($_POST['old_password'], ENT_QUOTES, 'UTF-8');
	$new_password_1 = htmlspecialchars($_POST['new_password_1'], ENT_QUOTES, 'UTF-8');
	$new_password_2 = htmlspecialchars($_POST['new_password_2'], ENT_QUOTES, 'UTF-8');

	$password_query = mysqli_query($con, "SELECT password FROM users WHERE username='$userLoggedIn'");
	$row = mysqli_fetch_array($password_query);
	$db_password = $row['password'];

	if(md5($old_password) == $db_password) {

		if($new_password_1 == $new_password_2) {

			if(!preg_match('/[^A-Za-z0-9]/', $new_password_1) || !preg_match('/[^A-Za-z0-9]/', $new_password_2)) {
		
				if(strlen($new_password_1) <= 4) {
					$password_message = "<p class='error_message' style='float:left;'>Your password must be greater than 4 characters</p><br><br>";
				}
				else {
					$new_password_md5 = md5($new_password_1);
					$password_query = "UPDATE users SET password=? WHERE username=?";

					$stmt = mysqli_stmt_init($con);

					if(!mysqli_stmt_prepare($stmt, $password_query)) {
						echo "Error";
					}
					else {
						mysqli_stmt_bind_param($stmt, "ss", $new_password_md5, $userLoggedIn);

						mysqli_stmt_execute($stmt);

						$password_message = "<p class='success_message' style='float:left;'>Your password is updated!</p><br>";
					}

				}
			}
			else {
				$password_message = "<p class='error_message' style='float:left;'>Your password can only contain english characters or numbers</p><br><br><br>";
			}

		}
		else {
			$password_message = "<p class='error_message' style='float:left;'>Passwords did not match</p><br>";
		}

	}
	else {
			$password_message = "<p class='error_message' style='float:left;'>The old password is incorrect</p><br>";
	}

}
else {
	$password_message = "";
}

if(isset($_POST['update_gpa'])) {
	$gpa = htmlspecialchars($_POST['gpa'], ENT_QUOTES, 'UTF-8');
	$gpa = str_replace(' ', '', $gpa); //Remove spaces
	$gpa = round($gpa, 3);

	if(!($gpa < 0) || !($gpa > 4)) {
		$gpa_message = "<p class='success_message'>GPA updated</p><br>";

		$gpa_query = "UPDATE users SET gpa=? WHERE username=?";

		$stmt = mysqli_stmt_init($con);

			if(!mysqli_stmt_prepare($stmt, $gpa_query)) {
				echo "Error";
			}
			else {
				mysqli_stmt_bind_param($stmt, "ss", $gpa, $userLoggedIn);

				mysqli_stmt_execute($stmt);

				header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
			}

	}
	else {
		$gpa_message = "<p class='error_message' style='float:left;'>GPA must be a number between 0 and 4</p><br>";
	}
}
else {
	$gpa_message = "";
}

if(isset($_POST['close_account'])) {
	header("Location: close_account");
}

?>