<?php

// use phpmailer library to send mail
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
require '../mailer/Exception.php';

// Email address verification
function isEmail($email) {
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

if($_POST) {

    // Enter the email where you want to receive the message
    $emailTo = 'salonigarg2310@gmail.com';

    $clientEmail = addslashes(trim($_POST['email']));
    $subject = addslashes(trim($_POST['subject']));
    $message = addslashes(trim($_POST['message']));

    $array = array('emailMessage' => '', 'subjectMessage' => '', 'messageMessage' => '');

    if(!isEmail($clientEmail)) {
        $array['emailMessage'] = 'Invalid email!';
    }
    if($subject == '') {
        $array['subjectMessage'] = 'Empty subject!';
    }
    if($message == '') {
        $array['messageMessage'] = 'Empty message!';
    }
    if(isEmail($clientEmail) && $subject != '' && $message != '') {
        try {
            // email config
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'YOUR_USERNAME';
            $mail->Password = 'YOUR_PASSWORD';
            
            // email sending details
            $mail->setFrom($clientEmail, $clientEmail);
            $mail->addAddress($emailTo);
            $mail->Subject = $subject;
            $mail->msgHTML($message);
            $mail->AddReplyTo($clientEmail);        
            
            // send mail
            $mail->send();
            $array['mailSent'] = true;
        }
        catch (Exception $e) {
            $array['mailSent'] = false;
        }
    }        
    echo json_encode($array);
}
?>