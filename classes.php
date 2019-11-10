<?php
include("includes/header.php");
include("includes/form_handlers/class_handler.php");

$class_details_query = mysqli_query($con, "SELECT num_classes FROM users WHERE username='$userLoggedIn'");
$class_array = mysqli_fetch_array($class_details_query);
?>
<title>GradeGoal | Classes</title>
<div class="container-fluid classes" id="contents">
	<div class="container classes_main_box text-center">
		<?php
		$posts = new Add($con, $userLoggedIn);
		$posts->addClass();

		?>
		<div id="class_default" data-toggle="modal" data-target="#modal_class">
			<h3>Add a class</h3><br>
			<i class="fas fa-plus"></i>
		</div>
	</div>
</div>

<?php if($error_message != "") { //Opens the modal after submission ?>
  	<script>
  		$(document).ready(function() {
  			$('#modal_error').modal('show')
  		});
  	</script>
<?php } ?>

<!-- Modal -->
<div class="modal fade second" id="modal_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo $error_message; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade second" id="modal_class" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Enter class information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="classes" method="POST" class="class_info_form">
          <label>Class name</label><br>
          <input type="text" name="class_name" placeholder="Ex: MAT 101" autocomplete="off" required><br>
          <label>Current grade</label><br>
          <input type="text" name="current_grade" placeholder="Ex: 92.4" autocomplete="off" required><strong>%</strong><br>
          <label>Credits</label>
          <select class="form-control" name="credits" style="width: 60%; border: solid 1px #000;">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
          <label>Ending grade goal</label><br>
          <input type="text" name="grade_goal" placeholder="What grade do you want?" autocomplete="off" required><strong>%</strong><br>
          <label>Final exam weight</label><br>
          <input type="text" name="exam_weight" placeholder="How much is the final exam worth?" autocomplete="off" required><strong>%</strong><br><br>
          <input type="submit" name="add" value="Add Class" id="add_button">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>