<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

ob_start();
include 'config.php';

$siteKey = '6Lf8FC8pAAAAAHvKztxI1vMKNLIOPy03zyrlv303';
$secretKey = '6Lf8FC8pAAAAACQ4ncwx-Fx-2gt9_l6fW1P3_jDl';

$toEmail = 'kepspb@yahoo.com';
$fromName = 'MotoGP Tickets';
$formEmail = 'keps_bp@yahoo.com';

$postData = $statusMsg = $valErr = '';
$status = 'error';



if (isset($_POST['submit'])) {
    $postData = $_POST;
    $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
    $subject = htmlspecialchars(trim($_POST['subject']), ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');



    if (empty($name)) {
        $valErr .= 'Please enter your name.<br/>';
    }
    if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $valErr .= 'Please enter a valid email.<br/>';
    }
    if (empty($subject)) {
        $valErr .= 'Please enter subject.<br/>';
    }

    if (empty($message)) {
        $valErr .= 'Please enter your message.<br/>';
    }

    if (empty($valErr)) {
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            // Verificare reCAPTCHA si pe server
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);

            if ($responseData->success) {
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();                                       
                    $mail->Host = 'smtp.gmail.com';                       
                    $mail->SMTPAuth = true;                               
                    $mail->Username = 'bprotopopescu09@gmail.com'; 
                    $mail->Password = 'fxlc tcmm bjqi pbwa'; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                             
                    $mail->Port = 587;                                      

                    $mail->setFrom('bprotopopescu09@gmail.com', 'MotoGP Tickets');
                    $mail->addAddress('kepspb@yahoo.com'); 

                    // Continut e-mail
                    $mail->isHTML(true);                                   
                    $mail->Subject = 'New contact request submitted';
                    $mail->Body    = "
                        <h2>Contact Request Details</h2>
                        <p><b>Name: </b>".$name."</p>
                        <p><b>Email: </b>".$email."</p>
                        <p><b>Subject: </b>".$subject."</p>
                        <p><b>Message: </b>".$message."</p>
                    ";

                    $mail->send();
                    $statusMsg = 'Thank you! Your contact request has been submitted successfully.';
                } catch (Exception $e) {
                    $statusMsg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                $statusMsg = 'Robot verification failed, please try again.';
            }
        } else {
            $statusMsg = 'Please check on the reCAPTCHA box.';
        }
    } else {
        $statusMsg = '<p>Please fill all the mandatory fields:</p>' . trim($valErr, '<br/>');
    }
}
?>
