<?php
include("includes/register_header.php");
?>

<div class="container-fluid calculator text-center">
	<div class="row">
		<div class="col-lg-12">
			<h2>Calculate what you need to get on the final exam</h2><br>
				<form>
					<label>What is your current grade?</label><br>
					<input type="number" min="0" max="100" name="text" id="current_grade" placeholder="Current grade" required><strong>%</strong><br>
					<label>What grade do you want to end the class?</label><br>
					<input type="number" min="0" max="100" name="text" id="grade_goal" placeholder="Grade goal" required><strong>%</strong><br>
					<label>How much is your exam worth?</label><br>
					<input type="number" min="0" max="100" name="text" id="exam_weight" placeholder="Exam weight" required><strong>%</strong><br><br>
					<input type="reset" value="Calculate" onclick="calculateGrade()" data-toggle="modal" data-target="#displayModal" id="submit-button">
				</form>
		</div>
	</div>
</div>

<div class="container-fluid how">
	<div class="row">
		<div class="col-lg-12">
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

<!-- Modal -->
<div class="modal fade" id="displayModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">You need to get at least an...</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" id="display" style="border:none; width: 50px; font-size: 19px; font-weight: bold;"><strong><span id="percentSymbol"></span></strong><br><br>
        <h5><p id="gradeDisplay" style="display: inline-block;"></p></h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
include("includes/footer.php");
?>