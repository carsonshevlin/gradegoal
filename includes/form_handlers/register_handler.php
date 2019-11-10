<?php
//Declaring variables to prevent errors
$fname = ""; // First name
$lname = ""; // Last name
$em = ""; // Email
$password = ""; // Password
$password2 = ""; // Password 2
$date = ""; // Sign up date
$gpa = "NA"; // GPA
$error_array = array(); // Holds error messages

if(isset($_POST['register_button'])) {

	//Registration form values
	// First name
	$fname = htmlspecialchars($_POST['reg_fname'], ENT_QUOTES, 'UTF-8'); //Remove html tags
	$fname = str_replace(' ', '', $fname); //Remove spaces
	$fname = ucfirst(strtolower($fname)); //Uppercase first letter
	$_SESSION['reg_fname'] = $fname; // Stores first name into session variable

	// Last name
	$lname = htmlspecialchars($_POST['reg_lname'], ENT_QUOTES, 'UTF-8'); //Remove html tags
	$lname = str_replace(' ', '', $lname); //Remove spaces
	$lname = ucfirst(strtolower($lname)); //Uppercase first letter
	$_SESSION['reg_lname'] = $lname; // Stores last name into session variable

	// Email
	$em = htmlspecialchars($_POST['reg_email'], ENT_QUOTES, 'UTF-8'); //Remove html tags
	$em = str_replace(' ', '', $em); //Remove spaces
	$em = strtolower($em); //Lower case
	$_SESSION['reg_email'] = $em; // Stores email into session variable

	// Password
	$password = htmlspecialchars($_POST['reg_password'], ENT_QUOTES, 'UTF-8'); //Remove html tags

	// Password 2
	$password2 = htmlspecialchars($_POST['reg_password2'], ENT_QUOTES, 'UTF-8'); //Remove html tags

	// GPA
	$gpa = htmlspecialchars($_POST['reg_gpa'], ENT_QUOTES, 'UTF-8'); //Remove html tags
	$gpa = str_replace(' ', '', $gpa); //Remove spaces
	$gpa = round($gpa, 3);

	$date = date("Y-m-d");// Current date

	//Check if email is on valid format
	if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

		$em = filter_var($em, FILTER_VALIDATE_EMAIL);

		//Check if email already exists
		$e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

		//Count number of rows returned
		$num_rows = mysqli_num_rows($e_check);

		if($num_rows > 0) {
			array_push($error_array, "Email already in use<br>");
		}
	}
	else {
		array_push($error_array, "Invalid email format<br>");
	}

	if(strlen($fname) > 25 || strlen($fname) < 2) {
		array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
	}

	if(strlen($lname) > 25 || strlen($lname) < 2) {
		array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
	}

	if($password != $password2) {
		array_push($error_array, "Your passwords do not match<br>");
	}
	else {
		if(preg_match('/[^A-Za-z0-9]/', $password)) {
			array_push($error_array, "Your password can only contain english characters or numbers<br>");
		}
	}

	if(strlen($password) > 30 || strlen($password) < 5) {
		array_push($error_array, "Your password must be between 5 and 30 characters<br>");
	}

	if(!empty($_POST['reg_gpa'])){
		if(!is_numeric($gpa) || ($gpa < 0 || $gpa > 4)) {
			array_push($error_array, "GPA must be a number between 0 and 4<br>");
		}
	}
	else {
		$gpa = "NA";
	}

	if(empty($error_array)) {
		$password = md5($password); // Encrypts the password

		//Generate username
		$username = strtolower($fname . "_" . $lname);
		$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

		$i = 0;
		//if username exists add number to username
		while(mysqli_num_rows($check_username_query) != 0) {
			$i++; // add 1 to i
			$username = $username . "_" . $i;
			$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
		}

		$id = '';
		$num_classes = 0;
		$user_closed = 'no';

		$query = "INSERT INTO users (id, first_name, last_name, username, email, password, signup_date, num_classes, gpa, user_closed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$stmt = mysqli_stmt_init($con);
		if(!mysqli_stmt_prepare($stmt, $query)) {
			echo "Error";
		}
		else {
			mysqli_stmt_bind_param($stmt, "issssssiss", $id, $fname, $lname, $username, $em, $password, $date, $num_classes, $gpa, $user_closed);
			mysqli_stmt_execute($stmt);
		}

		//Clear session variables
		$_SESSION['reg_fname'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['reg_gpa'] = "";

		$_SESSION['username'] = $username;
		header("Location: index.php");
	}
}
?>