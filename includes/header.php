<?php

require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Add.php");

if(isset($_SESSION['username'])) {
  $userLoggedIn = $_SESSION['username'];
  $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
  $user = mysqli_fetch_array($user_details_query);
}
else {
  header("Location: register");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">

  	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/bootbox.min.js"></script>
  	<script src="assets/js/bootstrap.js"></script>
  	<script src="assets/js/bootstrap.bundle.js"></script>
</head>
<body>

<div id="title_logo">
    <a href="/"><img src="assets/images/logo.png" onContextMenu="return false;"></a><br>
    <h3>GradeGoal</h3>
</div>

<hr>

<nav class="navbar navbar-expand-sm" data-toggle="affix">
    <div class="mx-auto d-sm-flex d-block flex-sm-nowrap">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation" style="margin-left: 200px;">
          <span class="navbar-toggler-icon" style="">   
              <i class="fas fa-bars" style="color:#000; font-size:28px;"></i>
          </span>
        </button>
        <div class="collapse navbar-collapse text-center" id="navbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gradecalculator">Calculator</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="classes">Classes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="includes/handlers/logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

</body>
</html>