<?php
	
	if(isset($_POST['login_button'])) {
		$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);
		$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
		$_SESSION['log_email'] = $email;//Store email into session variable
		$password = md5($_POST['log_password']);
		$password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

		$check_database_query = "SELECT * FROM users WHERE email=? AND password=?;";

		$stmt = mysqli_stmt_init($con);

		if(!mysqli_stmt_prepare($stmt, $check_database_query)) {
			echo "Connection error";
		}
		else {
			mysqli_stmt_bind_param($stmt, "ss", $email, $password);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			$check_login_query = mysqli_num_rows($result);

			if($check_login_query == 1) {
				$row = mysqli_fetch_array($result);
				$username = $row['username'];

				$user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_closed='yes'");
				if(mysqli_num_rows($user_closed_query) == 1) {
					$reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'");
				}

				$_SESSION['username'] = $username;
				header("Location: /");
				exit();
			}
			else {
				array_push($error_array, "Email or password was incorrect<br>");
			}
		}

	}

?>