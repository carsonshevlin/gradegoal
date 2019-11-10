<?php 
require '../../config/config.php';

$userLoggedIn = $_SESSION['username'];
	
	if(isset($_GET['id']))
		$post_id = $_GET['id'];
 
	if(isset($_POST['result'])) {
		if($_POST['result'] == 'true')
			$yes = 'yes';
			$query = "UPDATE classes SET deleted=? WHERE id=?";

			$stmt = mysqli_stmt_init($con);

				if(!mysqli_stmt_prepare($stmt, $query)) {
					echo "Error";
				}
				else {
					mysqli_stmt_bind_param($stmt, "si", $yes, $post_id);

					mysqli_stmt_execute($stmt);

				}

			$user_query = "UPDATE users SET num_classes=(num_classes - 1) WHERE username='$userLoggedIn'";

			if(!mysqli_stmt_prepare($stmt, $user_query)) {
				echo "Error";
			}
			else {
				mysqli_stmt_bind_param($stmt, "s", $userLoggedIn);

				mysqli_stmt_execute($stmt);

			}
	}
 
?>