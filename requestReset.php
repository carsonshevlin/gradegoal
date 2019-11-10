<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>
</html>

<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'config/config.php';

$error_message = "";

if(isset($_POST['email'])) {

    $to_mail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $to_mail = htmlspecialchars($to_mail, ENT_QUOTES, 'UTF-8');

    //prepared statement for checking if email is in database
    $check_database_query = "SELECT email FROM users WHERE email=?;";

    $stmt = mysqli_stmt_init($con);

    if(!mysqli_stmt_prepare($stmt, $check_database_query)) {
        echo "Error";
    }
    else {
        mysqli_stmt_bind_param($stmt, "s", $to_mail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $check_database_query = mysqli_fetch_array($result);

        if($check_database_query['email'] == $to_mail) {

            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);

            $code = uniqid(true);

            //prepared statement for inserting info into reset_passwords table
            $query = "INSERT INTO reset_passwords(code, email) values(?, ?)";

            if(!mysqli_stmt_prepare($stmt, $query)) {
                echo "Error";
            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $code, $to_mail);
                mysqli_stmt_execute($stmt);
            }

            if(!$query) {
                exit("Error");
            }

            try {
                //Server settings
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'gradegoal@gmail.com';                     // SMTP username
                $mail->Password   = '6KDrccK3g3#DtGCV';                               // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;                                   // TCP port to connect to

                //Recipients
                $mail->setFrom('gradegoal@gmail.com', 'GradeGoal');
                $mail->addAddress($to_mail);     // Add a recipient
                $mail->addReplyTo('no-reply@gmail.com', 'No reply');

                // Content
                $url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/reset_password?c=$code";
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Your password reset link';
                $mail->Body    = "<h1>You requested a password reset</h1>
                                  <h4>Click <a href='$url'>this link</a> to reset your password</h4>";
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                echo '<body class="reset_password_body">
                        <div class="text-center reset_password_form">
                            <h2>Reset password link has been sent to your email</h2>
                        </div>
                      </body>';
            } catch (Exception $e) {
                echo "<body class='reset_password_body'>
                        <div class='text-center reset_password_form'>
                            <h2>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</h2>
                        </div>
                      </body>";
            }
            exit();
        }
        else {
            $error_message = "<p class='error_message' style='width: 250px; text-align: center;'>Email is not in our system</p>";
        }
    }
    
}

?>

<body class="reset_password_body">

<form method="POST" class="text-center reset_password_form">
    <h2>Enter your email to reset your password</h2>
    <input type="email" name="email" placeholder="Email" autocomplete="off" required>
    <br>
    <?php echo $error_message; ?>
    <br>
    <input type="submit" name="submit" value="Submit">
</form>

</body>