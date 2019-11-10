<?php
	if(isset($_POST['add'])) {

		$class_name = htmlspecialchars($_POST['class_name'], ENT_QUOTES, 'UTF-8');
		$current_grade = htmlspecialchars($_POST['current_grade'], ENT_QUOTES, 'UTF-8');
		$grade_goal = htmlspecialchars($_POST['grade_goal'], ENT_QUOTES, 'UTF-8');
		$exam_weight = htmlspecialchars($_POST['exam_weight'], ENT_QUOTES, 'UTF-8');
		$credits = htmlspecialchars($_POST['credits'], ENT_QUOTES, 'UTF-8');

		if($current_grade >= 90) {
			$gpa_points = 4;
		}
		elseif($current_grade >= 80) {
			$gpa_points = 3;
		}
		elseif($current_grade >= 70) {
			$gpa_points = 2;
		}
		else {
			$gpa_points = 1;
		}

		$score = $credits * $gpa_points;

		$error_message = "";

		$rand = rand(0, 12);
		$image = "";
		if($rand == 0)
			$image = 'assets/images/class_images/green.jpg';
		elseif ($rand == 1)
			$image = 'assets/images/class_images/leaves.jpg';
		elseif ($rand == 2)
			$image = 'assets/images/class_images/night.jpg';
		elseif ($rand == 3)
			$image = 'assets/images/class_images/ocean.jpg';
		elseif ($rand == 4)
			$image = 'assets/images/class_images/river.jpg';
		elseif ($rand == 5)
			$image = 'assets/images/class_images/rock.jpg';
		elseif ($rand == 6)
			$image = 'assets/images/class_images/snow.jpg';
		elseif ($rand == 7)
			$image = 'assets/images/class_images/sunset.jpg';
		elseif ($rand == 8)
			$image = 'assets/images/class_images/trees.jpg';
		elseif ($rand == 9)
			$image = 'assets/images/class_images/mountain.jpg';
		elseif ($rand == 10)
			$image = 'assets/images/class_images/stars.jpg';
		else
			$image = 'assets/images/class_images/desert.jpg';

		//get username
		$added_by = $_SESSION['username'];

		if(strlen($class_name) > 15 || strlen($class_name) < 2) {
			$error_message = "Class name must be between 2 and 15 characters";
		}
		if((is_numeric($current_grade) == false) || ($current_grade < 0 || $current_grade > 100)) {
			$error_message = "Current grade must be a positive number less than or equal to 100";
		}
		if((is_numeric($grade_goal) == false) || ($grade_goal <= 0 || $grade_goal > 100)) {
			$error_message = "Grade goal must be a positive number less than or equal to 100";
		}
		if((is_numeric($exam_weight) == false) || ($exam_weight < 0 || $exam_weight > 100)) {
			$error_message = "Exam weight must be a positive number less than or equal to 100";
		}

		if($error_message == "") {
			$current_grade = number_format($current_grade, 1);
			$grade_goal = number_format($grade_goal, 1);
			$exam_weight = number_format($exam_weight, 0);
			$exam_weight = $exam_weight / 100;
			$score_needed = ($grade_goal - ((1 - $exam_weight) * $current_grade)) / $exam_weight;
			$id = '';
			$deleted = 'no';
			$user_closed = 'no';
			$class_id = uniqid(true);
			$query = "INSERT INTO classes (id, class_id, added_by, image, class_name, current_grade, credits, score, grade_goal, exam_weight, score_needed, deleted, user_closed) VALUES (?, ?, ?, '$image', ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt = mysqli_stmt_init($con);
			if(!mysqli_stmt_prepare($stmt, $query)) {
				echo "Error";
			}
			else {
				mysqli_stmt_bind_param($stmt, "isssdiiddiss", $id, $class_id, $added_by, $class_name, $current_grade, $credits, $score, $grade_goal, $exam_weight, $score_needed, $deleted, $user_closed);

				mysqli_stmt_execute($stmt);

				//update post count for user
				$user_obj = new User($con, $added_by);
			    $num_classes = $user_obj->getNumClasses();
			    $num_classes++;
			    $update_query = mysqli_query($con, "UPDATE users SET num_classes='$num_classes' WHERE username='$added_by'");

			    header("Location: classes.php");
			}
		}
	}
	else {
		$error_message = "";
	}

	if(isset($_GET['class'])) {
		$class_id = $_GET['class'];
	}
	else {
		$class_id = 0;
	}

	if(isset($_POST['edit'])) {

		$iclass_name = htmlspecialchars($_POST['iclass_name'], ENT_QUOTES, 'UTF-8');
		$icurrent_grade = htmlspecialchars($_POST['icurrent_grade'], ENT_QUOTES, 'UTF-8');
		$igrade_goal = htmlspecialchars($_POST['igrade_goal'], ENT_QUOTES, 'UTF-8');
		$iexam_weight = htmlspecialchars($_POST['iexam_weight'], ENT_QUOTES, 'UTF-8');
		$error_info_message = "";

		//get username
		$added_by = $_SESSION['username'];

		$get_credits_query = mysqli_query($con, "SELECT credits FROM classes WHERE added_by='$added_by' AND class_id='$class_id'");
		$credit_rows = mysqli_fetch_array($get_credits_query);
		$icredits = $credit_rows['credits'];

		if($icurrent_grade >= 90) {
			$igpa_points = 4;
		}
		elseif($icurrent_grade >= 80) {
			$igpa_points = 3;
		}
		elseif($icurrent_grade >= 70) {
			$igpa_points = 2;
		}
		else {
			$igpa_points = 1;
		}

		$iscore = $icredits * $igpa_points;

		if(strlen($iclass_name) > 15 || strlen($iclass_name) < 2) {
			$error_info_message = "Class name must be between 2 and 15 characters";
		}

		if((is_numeric($icurrent_grade) == false) || ($icurrent_grade < 0 || $icurrent_grade > 100)) {
			$error_info_message = "Current grade must be a positive number less than or equal to 100";
		}
		if((is_numeric($igrade_goal) == false) || ($igrade_goal <= 0 || $igrade_goal > 100)) {
			$error_info_message = "Grade goal must be a positive number less than or equal to 100";
		}
		if((is_numeric($iexam_weight) == false) || ($iexam_weight < 0 || $iexam_weight > 100)) {
			$error_info_message = "Exam weight must be a positive number less than or equal to 100";
		}

		if($error_info_message == "") {
			$icurrent_grade = number_format($icurrent_grade, 1);
			$igrade_goal = number_format($igrade_goal, 1);
			$iexam_weight = number_format($iexam_weight, 0);
			$iexam_weight = $iexam_weight / 100;
			$score_needed = ($igrade_goal - ((1 - $iexam_weight) * $icurrent_grade)) / $iexam_weight;
			$query = "UPDATE classes SET class_name=?, current_grade=?, grade_goal=?, exam_weight=?, score=?, score_needed=? WHERE added_by='$added_by' AND class_id='$class_id'";

			$stmt = mysqli_stmt_init($con);
			if(!mysqli_stmt_prepare($stmt, $query)) {
				echo "Error";
			}
			else {
				mysqli_stmt_bind_param($stmt, "sdidii", $iclass_name, $icurrent_grade, $igrade_goal, $iexam_weight, $iscore, $score_needed);

				mysqli_stmt_execute($stmt);

				header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
			}
		}
	}
	else {
		$error_info_message = "";
	}

?>