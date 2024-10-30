<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'PHPMAILER/Exception.php';
require 'PHPMAILER/PHPMailer.php';
require 'PHPMAILER/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'jiban.niraula.59@gmail.com';                     //SMTP username
    $mail->Password   = 'hchy hhtb xqco zflp';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('jiban.niraula.59@gmail.com', 'Feedback by User');
    $mail->addAddress('jiban.niraula.59@gmail.com', 'Feedback hai');     //Add a recipient

  
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Test Contact Form';
    $mail->Body    = 'Dear admin!<br>Please find the feedback below</b>';
   
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}