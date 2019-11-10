<?php
include("includes/header.php");
include("includes/form_handlers/class_handler.php");

if(isset($_SESSION['username']) == $userLoggedIn) {

	$posts = new Add($con, $userLoggedIn);
	$posts->classInfo($class_id);

}
else {
	header("classes");
}

if($error_info_message != "") { //Opens the modal after submission ?>
  	<script>
  		$(document).ready(function() {
  			$('#modal_info_error').modal('show')
  		});
  	</script>
<?php } ?>
<title>GradeGoal | Class Info</title>
<!-- Modal -->
<div class="modal fade second" id="modal_info_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo $error_info_message; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>