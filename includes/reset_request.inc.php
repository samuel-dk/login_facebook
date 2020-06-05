<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require "dbh.inc.php";

if (isset($_POST["email"])) {
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $email_to = $_POST["email"];
    $code = uniqid(true);
    $query = mysqli_query($conn, "INSERT INTO reset_passwords(code,email) VALUES('$code', '$email_to')");

    if (!$query) {
        exit("Error");
    }

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
        $mail->isSMTP(); // Send using SMTP
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'samuel.dk.test@gmail.com'; // SMTP username
        $mail->Password = '**********'; // SMTP password
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('samuel.dk.test@gmail.com', 'Samuel');
        $mail->addAddress("$email_to"); // Add a recipient
        $mail->addReplyTo('no-reply@gmail.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/reset_password.inc.php?code=$code";
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Your password reset link';
        $mail->Body = "<h2>You requested a password reset</h2>
                        <p>Click <a href='$url'>this link</a> to do so</p>";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Reset password link has been sent to your email.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    exit();

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style/style_signup.css">
    <title>Reset Password</title>
</head>

<body>
    <form method="POST">
        <div class="container">
            <h1>Reset your Password</h1>
            <p>An e-mail will be send to you with instructions on how to reset your password.</p>
            <hr>

            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter your Email address..." name="email" required>

            <div class="clearfix">
                <a href="index.php"><button type="button" class="cancelbtn">Cancel</button></a>
                <button type="submit" class="signupbtn" name="submit">Send</button>
            </div>
        </div>
    </form>
</body>

</html>
