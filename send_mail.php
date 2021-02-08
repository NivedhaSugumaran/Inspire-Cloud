
<?php
function Send_Mail($to,$subject)
{
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';


// If necessary, modify the path in the require statement below to refer to the
// location of your Composer autoload.php file.
//require './vendor/autoload.php';

$mail = new PHPMailer\PHPMailer\PHPMailer(true);

// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
$sender = 'inspirecloud21@gmail.com';
$senderName = 'INSPIRE CLOUD';

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
$recipient = $to;

// Replace smtp_username with your Amazon SES SMTP user name.
$usernameSmtp = 'AKIAZZZTI7YGPCFOY57A';

// Replace smtp_password with your Amazon SES SMTP password.
$passwordSmtp = 'BARaQQnEnMPaWMeqHQmYLeSHVcFmHutioi2j+FDAJ2gA';

// Specify a configuration set. If you do not want to use a configuration
// set, comment or remove the next line.
//$configurationSet = 'ConfigSet';

// If you're using Amazon SES in a region other than US West (Oregon),
// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
// endpoint in the appropriate region.
$host = 'email-smtp.ap-south-1.amazonaws.com';
$port = 587;

// The subject line of the email
$subject = 'Successfully Registered !';

// The plain-text body of the email
$bodyText =  "You have successfully registered in this website!";

// The HTML-formatted body of the email
$bodyHtml = '<html>
             <h2>You can view your Cloud Certifications in the below <a href="http://13.235.16.1/login.php">link </a> <html>';



try {
    // Specify the SMTP settings.
    $mail->isSMTP();
    $mail->setFrom($sender, $senderName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
  //  $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);
    // Specify the message recipients.
    $mail->addAddress($recipient);
    // You can also add CC, BCC, and additional To recipients here.
    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;

 $mail->Body       = $bodyHtml;
    $mail->AltBody    = $bodyText;
    $mail->Send();
    echo "Email sent!" , PHP_EOL;
} catch (phpmailerException $e) {
    echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
} catch (Exception $e) {
    echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
}

}
?>

