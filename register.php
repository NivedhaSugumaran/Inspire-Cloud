<?php
// Include config file
require "config.php";
require 'send_mail.php';

// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    }
        else if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@gmail\.com$^",$_POST["email"]))
       {
                   $email_err = "Invalid email address";

     }
        else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
             mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
              //      echo '<script type="text/javascript">alert("hello");</script>';
                }
            } else{
                echo "Oops! Something went wrong. Please try again later."; }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
 }
    }

    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters

            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            $to = $email;
            $subject = "Successfully Registered !";

            Send_Mail($to,$subject);



            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
echo "<script>
                alert('Successfully Registered');
                window.location.href='login.php';
                </script>";
// header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);

}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{
background-color: #FFFFFF;

   width: 500px;
        height: 500px;
        margin: 4em auto;
box-shadow: 0px 11px 35px 2px rgba(0, 0, 0, 0.14); }

    .headcolo
{
color:white;
font-family:URW Chancery L, cursive;
font-size:70px;}



.headcolo img {
  float: left;
  width: 100px;
  height: 100px;
  background: #555;
 border-radius: 50%;

}

</style>
</head>
<header> <h1 class="headcolo">Inspire Cloud  <img src="https://cloud198.s3.ap-south-1.amazonaws.com/logo.png" /></h1></header>
<body style="background-color:#1E90FF;">
    <div class="wrapper"><br>
        <center><h2 >Sign Up</h2></center><br>
        <p>&nbsp Please fill this form to create an account.</p>
        <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label> &nbsp  Email</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>&nbsp  Password</label>
                <input type="password" id="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label> &nbsp  Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">&nbsp
 <input type="submit"  class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>&nbsp Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>

</body>
</html>


