<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'PHPMAILER/Exception.php';
require 'PHPMAILER/PHPMailer.php';
require 'PHPMAILER/SMTP.php';

function cleanData($data) {
    $data = trim($data);
    $data = htmlentities($data);
    return $data;
}

if (isset($_POST['submit'])) {
    $name = cleanData($_POST['name']);
    $address = cleanData($_POST['address']);
    $number = cleanData($_POST['number']);
    $feedback = cleanData($_POST['feedback']);
    $mail_to = "jiban.niraula.59@gmail.com";

    $errors = []; // Array to store error messages

    if (empty($name)) {
        $errors['name'] = "Please enter your name.";
    }

    if (empty($address)) {
        $errors['address'] = "Please enter your address.";
    } elseif (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
        $errors['address'] = "Please enter a valid email address.";
    }

    if (empty($number)) {
        $errors['number'] = "Please enter your contact number.";
    }

    if (empty($feedback)) {
        $errors['feedback'] = "Please enter your feedback.";
    }

    if (count($errors) > 0) {
        // Display errors on the form
        $_SESSION['errors'] = $errors;
        header('location:' . $_SERVER['PHP_SELF']);
        exit;
    }

    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'jiban.niraula.59@gmail.com';         // SMTP username
        $mail->Password   = 'hchy hhtb xqco zflp';                 // SMTP password (consider using environment variables for security)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          // Enable implicit TLS encryption
        $mail->Port       = 465;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom($address, $name);                           // Set sender's email and name from the form input
        $mail->addAddress($mail_to, 'Feedback hai');               // Add a recipient

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'Test Contact Form';
        $mail->Body    = "Dear admin!<br>Please find the feedback below:<br><strong>Name:</strong> $name<br><strong>Email:</strong> $address<br><strong>Contact Number:</strong> $number<br><strong>Feedback:</strong> $feedback";

        $mail->send();
        $_SESSION['done'] = 'Message has been sent successfully.';
    } catch (Exception $e) {
        $_SESSION['msg'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    header('location:' . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="card mt-3">
        <div class="card-header">
            <h2 class="alert alert-success">Feedback Form</h2>
            <h6>Please Enter the following data</h6>
        </div>
        <div class="card-body">

        <?php
         if (isset($_SESSION['msg'])) {
            echo "<div class='alert alert-danger'>";
            echo $_SESSION['msg'];
            echo "</div>";
            unset($_SESSION['msg']);
        }

        if (isset($_SESSION['done'])) {
            echo "<div class='alert alert-success'>";
            echo $_SESSION['done'];
            echo "</div>";
            unset($_SESSION['done']);
        }

        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
            unset($_SESSION['errors']);
        }
        ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

            <div class="mb-3"> 
                <label for="" class="fs-4">Name</label>
                <input type="text" placeholder="Please Enter your name" name="name" class="form-control">
            </div>

            <div class="mb-3"> 
                <label for="" class="fs-4">Email</label>
                <input type="email" name="address" placeholder="Please Enter your Email" class="form-control">
            </div>

            <div class="mb-3"> 
                <label for="" class="fs-4">Contact Number</label>
                <input type="number" name="number" placeholder="Please Enter your number" class="form-control">
            </div>

            <div class="mb-3"> 
                <label for="" class="fs-4">Your Feedback</label>
                <textarea name="feedback" placeholder="Please Enter your feedback" class="form-control" rows="4"></textarea>
            </div>

            <button type="submit" name="submit" class="btn btn-success float-end m-2 btn-lg">Submit</button>
        </form>

        </div>
    </div>
</body>
</html>
