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
include("config/config.php");

if(!isset($_GET['c'])) {
    exit("<body class='reset_password_body'>
                <div class='text-center reset_password_form'>
                    <h2>Hmm.. Can't find this page</h2>
                    <h3>Click <a href='register'>here</a> to return to the home page</h3>
                </div>
              </body>");
}

$code = $_GET['c'];
$pw = "";
$error_message = "";

$get_email_query = mysqli_query($con, "SELECT email FROM reset_passwords WHERE code='$code'");
if(mysqli_num_rows($get_email_query) == 0) {
    exit("<body class='reset_password_body'>
                <div class='text-center reset_password_form'>
                    <h2>Hmm.. Can't find this page</h2>
                    <h3>Click <a href='register'>here</a> to return to the home page</h3>
                </div>
              </body>");
}

if(isset($_POST['password'])) {
    $pw = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8'); //Remove special chars

    if(preg_match('/[^A-Za-z0-9]/', $pw)) {
         $error_message = "<p class='error_message' style='width: 250px; text-align: center;'>Your password can only only contain english characters or numbers</p>";
    }

    if(strlen($pw) > 30 || strlen($pw) < 5) {
        $error_message = "<p class='error_message' style='width: 250px; text-align: center;'>Your password must be between 5 and 30 characters</p>";
    }

    if($error_message == "") {

        $pw = md5($pw);

        $row = mysqli_fetch_array($get_email_query);
        $email = $row['email'];

        $query = "UPDATE users SET password=? WHERE email=?;";

        $stmt = mysqli_stmt_init($con);

        if(!mysqli_stmt_prepare($stmt, $query)) {
            echo "Connection error";
        }
        else {
            mysqli_stmt_bind_param($stmt, "ss", $pw, $email);
            mysqli_stmt_execute($stmt);

            if($stmt->execute()) {
                $query = mysqli_query($con, "DELETE FROM reset_passwords WHERE code='$code'");
                exit("<body class='reset_password_body'>
                        <div class='text-center reset_password_form'>
                            <h2>Your password has been updated</h2>
                            <h3>Click <a href='register'>here</a> to return to the home page</h3>
                        </div>
                      </body>");
            }
            else {
                exit("<body class='reset_password_body'>
                        <div class='text-center reset_password_form'>
                            <h2>Something went wrong</h2>
                            <h3>Click <a href='register'>here</a> to return to the home page</h3>
                        </div>
                      </body>");
            }
        }

    }
}

?>

<body class="reset_password_body">

<form method="POST" class="text-center reset_password_form">
    <h2>Enter your new password</h2>
    <input type="password" name="password" placeholder="New password" required>
    <br>
    <?php echo $error_message; ?>
    <br>
    <input type="submit" name="submit" value="Update password">
</form>

</body>
</html>