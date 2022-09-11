<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include("backend/User.php");

use User\User;

$app_url = "http://supervisor.test/change-password";
$userClass = new User();
//Load Composer's autoloader
require 'vendor/autoload.php';

if (isset($_POST["reset_password"])) {

    $email = $_POST["email"];
    $user = $userClass::where("email", "=", $email);
    if ($user == null) {
        header("Location: forgot-password?message=invalid");
    }
    $chars = "abcdefg4hijklmno-p5qrst2uvwxyzabc6defghijklm-nopqrst6uvwxy1zabc6defghij-klmnop6qrstuvwxyz7";
    $token = substr(str_shuffle($chars), 0, 50);
    // void all tokens
    $userClass::voidTokens($email);

    // save new token
    $userClass::saveToken($email, $token);
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'socialdll.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'supervise@socialdll.com';                     //SMTP username
        $mail->Password   = 'Alonso652@..';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;

        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        // $mail->isSMTP();                                            //Send using SMTP
        // $mail->Host       = 'rbx107.truehost.cloud';                     //Set the SMTP server to send through
        // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        // $mail->Username   = 'supervise@logiccamp.com.ng';                     //SMTP username
        // $mail->Password   = 'Alonso652@..';                               //SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        // $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('supervise@socialdll.com', 'Supervise');
        $mail->addAddress($user["email"], $user["full_name"]);     //Add a recipient

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'PASSWORD RESET - SUPERVISE';
        $mail->Body    = 'Thank you for using <b>Supervise</b>. <br /> You can simply follow the link below to reset your password. <br /> <a href="' . $app_url . '?token=' . $token . '">Reset Password</a>';

        $mail->send();
        header("Location: forgot-password?message=success");
    } catch (Exception $e) {
        echo $e;
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
