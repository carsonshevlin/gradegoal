<?php
include("includes/header.php");

//average grade
$avg_query = mysqli_query($con, "SELECT SUM(current_grade) AS sum_grade FROM classes WHERE added_by='$userLoggedIn' AND deleted='no'");
$row = mysqli_fetch_array($avg_query);
$sum_grade = round($row['sum_grade'], 1);
if($user['num_classes'] > 0) {
	$avg_grade = $sum_grade / $user['num_classes'];
}
else {
	$avg_grade = 0;
}
$avg_grade = round($avg_grade, 1);

//gpa score
$gpa_query = mysqli_query($con, "SELECT SUM(score) / SUM(credits) AS gpa_score FROM classes WHERE added_by='$userLoggedIn' AND deleted='no'");
$gpa_row = mysqli_fetch_array($gpa_query);
$start_gpa = $user['gpa'];
if($start_gpa != "NA") {
$start_gpa = number_format($start_gpa, 2);
}
$gpa_score = number_format($gpa_row['gpa_score'], 2);

if($start_gpa != "NA") {
  if($gpa_score == 0)
    $final_gpa = $start_gpa;
  else {
    $final_gpa = ($start_gpa + $gpa_score) / 2;
    $final_gpa = number_format($final_gpa, 2);
  }
}
else
  $final_gpa = "NA";

if($user['num_classes'] < 3)
  $class_message = "Keep adding classes!";
elseif($user['num_classes'] < 6) 
  $class_message = "You are going to ace these classes!";
else
  $class_message = "That's a lot of classes!";

?>
<title>GradeGoal | <?php echo $user['first_name']; ?></title>
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
           <h2 id="user">Welcome <?php echo $user['first_name'] ?>!</h2>
        </div>
        <div class="col-lg-12">
          <div class='card text-center' style='min-height: 300px; padding: 70px 0; background-color: #ff7979;'>
              <h1 id='quoteDisplay'></h1>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <a href="classes" style="color: #fff;"><i class="fas fa-pencil-alt"></i></a>
              </div>
              <a href="classes" id="class_page_link"><h2 class="card-category" id="home_section_names">Classes</h2></a>
              <h3 class="card-title"><?php echo $user['num_classes']; ?></h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons"><?php echo $class_message; ?></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <a tabindex="0" id="gpa_info_pop" role="button" data-toggle="popover" data-trigger="focus" title="How is this calculated?"
                   data-content="We sum all of your current grades and then divide that total by the
                   number of classes you have.">
                   <i class="fas fa-percent" style="color: #fff;"></i></a>
              </div>
              <h2 class="card-category" id="home_section_names">Average Grade</h2>
              <h3 class="card-title"><?php echo $avg_grade; ?>%</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">Basic average</i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <a tabindex="0" id="gpa_info_pop" role="button" data-toggle="popover" data-trigger="focus" title="How is GPA calculated?"
                   data-content="From 0.0 to 4.0, we  divide your total number of grade points by the total number of credits you have.">
                   <i class="fas fa-graduation-cap" style="color: #fff;"></i></a>
              </div>
              <h2 class="card-category" id="home_section_names">GPA</h2>
              <h3 class="card-title"><?php echo $final_gpa; ?></h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">Based on a 4.0 scale <a tabindex="0" id="gpa_info_pop" role="button" data-toggle="popover" data-trigger="focus" title="GPA Info" data-content="GradeGoal does not account + or - for letter grade. A: 90-100, B: 80-89, C: 70-79, D: < 70"><i class="far fa-question-circle"></i></a></i>
              </div>
            </div>
          </div>
        </div>
        <?php  
            if($user['num_classes'] == 0) {
              echo "<div class='col-lg-12'>
                      <div class='card text-center' style='min-height: 300px;'>
                        <h2 style='margin:25px 15px;'>Start adding your classes</h2>
                        <a href='classes' id='add_class_link'>Add classes</a>
                      </div>
                    </div>";
            }
            else {

              echo "<div class='col-lg-12'>
                            <div class='card card-stats' style='min-height: 300px;'>
                              <div class='card-header card-header-info card-header-icon'>
                                <div class='card-icon'>
                                  <i class='fas fa-brain'></i>
                                </div>
                                <h2 class='card-category' id='home_section_names'>Report Card</h2>";
                                $letters = new Add($con, $userLoggedIn);
                                $letters->displayLetterGrade();
                              echo "
                              </div>
                              <div class='card-footer'>
                                
                              </div>
                            </div>
                          </div>";
            }
        ?>
      </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
<script>
  $(function () {
    $('[data-toggle="popover"]').popover()
  })
  $('.popover-dismiss').popover({
    trigger: 'focus'
  })
</script>