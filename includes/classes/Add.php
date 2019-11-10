<?php

	class Add {
		private $user_obj;
		private $con;

		public function __construct($con, $user){
			$this->con = $con;
			$this->user_obj = new User($con, $user);
		}

		public function addClass() {
			$str = ""; //string to return
			$userLoggedIn = $_SESSION['username'];
			$data_query = mysqli_query($this->con, "SELECT * FROM classes WHERE deleted='no' and added_by='$userLoggedIn' ORDER BY id DESC");

			if(mysqli_num_rows($data_query) > 0) {
				while($row = mysqli_fetch_array($data_query)) {
					$id = $row['id'];
					$image = $row['image'];
					$class_name = $row['class_name'];
					$class_id = $row['class_id'];
					$delete_button = "<button class='delete_button' id='post$id'><i class='far fa-trash-alt'></i></button>";

					$str .= "
								<div class='class_box' style='background-image: url($image); background-position: center; background-repeat: no-repeat; background-size: cover;'>
									<a href='info?class=$class_id' style='color:#000;' class='class_link'><h3>$class_name</h3></a><br>
									$delete_button
								</div>
							";

					?>
					<script>
 
						$(document).ready(function() {
					 
							$('#post<?php echo $id; ?>').on('click', function() {
								bootbox.confirm("Are you sure you want to delete this class?", function(result) {
					 
									if(result) {
										$.post("includes/form_handlers/delete_class.php?id=<?php echo $id; ?>", {result:result})
									    setTimeout(function(){
										location.reload()
									    }, 300)
									}
					 
								});
							});
					 
					 
						});
					 
					</script>
					<?php
				}

				echo $str;
			}
		}

		public function classInfo($class_id) {
			$str = "";
			$userLoggedIn = $_SESSION['username'];
			$user_details_query = mysqli_query($this->con, "SELECT * FROM classes WHERE class_id='$class_id' AND added_by='$userLoggedIn' AND deleted='no'");
			$user_array = mysqli_fetch_array($user_details_query);

			$class_id = $user_array['class_id'];
			$class_name = $user_array['class_name'];
			$image = $user_array['image'];
			$current_grade = $user_array['current_grade'];
			$grade_goal = $user_array['grade_goal'];
			$exam_weight = $user_array['exam_weight'];
			$score_needed = $user_array['score_needed'];

			if(mysqli_num_rows($user_details_query) > 0) {

			echo "
				<div class='container-fluid class_banner' style='background-image: url($image); background-position: center; background-repeat: no-repeat; background-size: cover; height: 200px; margin-top:-15px;' >
					<div class='container class_title'>
						<h2>$class_name</h2>
					</div>
				 </div>
				 <div class='container-fluid main_class_info'>
				 <button type='button' data-toggle='modal' data-target='#modal_class' id='edit_button'>Update Class</button>
					 <div class='container class_info_contents text-center'>
					 	<div class='class_info'>
					 		<h3>Your grade goal:</h3><br>
					 		<h3><b>$grade_goal %</b></h3>
					 	</div>
					 	<div class='class_info'>
					 		<h3>Your current grade:</h3><br>
					 		<h3><b>$current_grade %</b></h3>
					 	</div>
					 	<div class='class_info'>
					 		<h3>Exam score needed:</h3><br>
					 		<h3><b>$score_needed %</b></h3>
					 	</div>
					 </div>
				 </div>
				 <div class='container-fluid how'>
				  <div class='row'>
				    <div class='col-lg-12'>
				      <h2>How is this Calculated?</h2>
				      <p>There are three components to this calculation:</p><br>
				      <ul>
				        <li>Current Grade denoted as <b>C</b>, can be found by dividing your total points earned by the totals points available in the class.</li>
				        <li>Grade Goal denoted as <b>G</b>, is the grade that you wish to have after taking the exam.</li>
				        <li>Exam Weight denoted as <b>W</b>, is how much the exam is worth compared to the total points in the class. Usually this can be found in the class syllabus.</li>
				      </ul>
				      <br>
				      <h4>Score needed = (G - (1 - W) * C) / W</h4>
				    </div>
				  </div>
				</div>
				 <div class='modal fade second' id='modal_class' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
				  <div class='modal-dialog modal-dialog-centered' role='document'>
				    <div class='modal-content'>
				      <div class='modal-header'>
				        <h5 class='modal-title'>Enter $class_name information</h5>
				        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				          <span aria-hidden='true'>&times;</span>
				        </button>
				      </div>
				      <div class='modal-body'>
				        <form action='info?class=$class_id' method='POST' class='class_info_form'>
				        	<label>Class name</label><br>
				          <input type='text' name='iclass_name' placeholder='Ex: MAT 101' autocomplete='off' required><br>
				          <label>Current grade</label><br>
				          <input type='text' name='icurrent_grade' placeholder='Ex: 92.4' autocomplete='off' required><strong>%</strong><br>
				          <label>Credits</label>
				          <label>Ending grade goal</label><br>
				          <input type='text' name='igrade_goal' placeholder='What grade do you want?'' autocomplete='off' required><strong>%</strong><br>
				          <label>Final exam weight</label><br>
				          <input type='text' name='iexam_weight' placeholder='How much is the final exam worth?'' autocomplete='off' required><strong>%</strong><br><br>
				          <input type='submit' name='edit' value='Update Class' id='add_button'>
				        </form>
				      </div>
				      <div class='modal-footer'>
				        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
				      </div>
				    </div>
				  </div>
				</div>";
			}
			else {
				echo "
				<div class='container-fluid no_page'>
				 <div class='container text-center'>
				 	<div class='row'>
				 		<div class='col-lg-12'>
				 			<h2>Oops. We can't find this class</h2>
				 			<h5>You don't have a class with this id</h5>
				 			<br>
				 			<h4>Questions? Contact us <a href='mailto:gradegoal@gmail.com'>here</a></h4>
				 		</div>
				 	</div>
				 </div>
				</div>";
			}
		}

		public function displayLetterGrade() {
			$str = ""; //string to return
			$userLoggedIn = $_SESSION['username'];
			$data_query = mysqli_query($this->con, "SELECT * FROM classes WHERE deleted='no' and added_by='$userLoggedIn' ORDER BY id ASC");

			if(mysqli_num_rows($data_query) != 0) {
				while($row = mysqli_fetch_array($data_query)) {
					$class_name = $row['class_name'];
					$current_grade = $row['current_grade'];
					if($current_grade >= 90) {
						$letter = "A";
						$color = "#2ed573";
					}
					elseif($current_grade >= 80) {
						$letter = "B";
						$color = "#fed330";
					}
					elseif($current_grade >= 70) {
						$letter = "C";
						$color = "#fd9644";
					}
					elseif($current_grade >= 60) {
						$letter = "D";
						$color = "#ff4757";
					}
					else {
						$letter = "F";
						$color = "#ff4757";
					}

					$str .= "
								<h3 class='card-title' style='color:#000;'>$class_name " . ": " . "<p style='color:$color; display:inline-block;'>$letter</p></h3>
								
							";

				}

				echo $str;
			}
		}

	}

?>