<?php
include("includes/register_header.php");

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$msg = '';
  $msgClass = '';

  if (filter_has_var(INPUT_POST, 'submit')) {
    $name = htmlspecialchars($_POST['name']);
    $mail = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Check Required Fields
    if (!empty($mail) && !empty($name) && !empty($message)) {

      //Check Email
      if (filter_var($mail, FILTER_VALIDATE_EMAIL) === false) {
        //Failed
        $msg = 'Please use a valid email';
        $msgClass = 'alert-danger';
      } else {
        $toEmail = 'gradegoal@gmail.com';
        $subject = 'Contact Request From '.$name;
        $body = '<h2>Contact Request</h2>
          <h4>Name</h4><p>'.$name.'</p>
          <h4>Email</h4><p>'.$mail.'</p>
          <h4>Message</h4><p>'.$message.'
        ';

        //Headers
        $headers = "MIME-Version: 1.0" ."\r\n";
        $headers .="Content_Type:text/html;charset=UTF-8" . "\r\n";

        $headers .= "From: " .$name. "<".$mail.">". "\r\n";

        if (mail($toEmail, $subject, $body, $headers)) {
          //Email Sent
          $msg = 'Your email has been sent';
          $msgClass = 'alert-success';
        } else {
          //Failed
          $msg = 'Your email was not sent';
          $msgClass = 'alert-danger';
        }
      }
      
    } else {
      $msg = 'Please fill in all fields';
      $msgClass = 'alert-danger';
    }
  }

?>

<div class="container-fluid about text-center">
    <div class="row">
        <div class="col-lg-6 about_box">
            <h2>About Us</h2>
            <p>Just two college dudes</p>
            <p>We are currently attending Northern Arizona University studying Business/Computer Science and Film/Business.
               We noticed that existing online grade calculators are outdated and don't save your data, so we decided to build this website. 
               Hope you enjoy!</p>
        </div>
        <div class="col-lg-6 about_pic">
            
        </div>
        <div class="col-lg-12 contact_title">
          <h2>Have any questions or want to collaborate?</h2>
          <h4>Just send us an email with your specific question or project idea, We will get to you within a day or two.</h4>
        </div>
        <div class="container box">
	        <?php if ($msg != ''): ?>
	          <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
	        <?php endif; ?> 

	        <form action="about" method="post">

	        <label for="name">Name</label><br>
	        <input type="text" name="name" class="contact_input" style="height:40px" placeholder="Your full name.." value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
	        <br>
	        <label for="mail">Email</label><br>
	        <input type="email" name="email" class="contact_input" style="height:40px" placeholder="Your email.." value="<?php echo isset($_POST['mail']) ? $mail : ''; ?>">
	        <br>
	        <label for="message">Message</label><br>
	        <textarea name="message" placeholder="Your message.." style="height:200px"><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
	        <br>
	        <input type="submit" name="submit" value="Submit">
	        </form>
      	</div>
    </div>
</div>

<?php
include("includes/footer.php");
?>

