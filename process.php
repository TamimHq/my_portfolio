<?php
$to = "tamimhaque13@gmail.com";
$response = array('status' => 0, 'message' => 'Unknown error occurred.');

if (!empty($_POST)) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    $honeypot = htmlspecialchars($_POST['url']);

    if (!empty($honeypot)) {
        echo json_encode(array('status'=>0,'message'=>'There was a problem'));
        die();
    }

    if (empty($name) || empty($email) || empty($message) || empty($subject)) {
        echo json_encode(array('status'=>0,'message'=>'There is something in the field missing'));
        die();
    }

    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$email) {
        echo json_encode(array('status'=>0,'message'=>'Not valid Email'));
        die();
    }

    $headers = sprintf("From: %s",$email . "\r\n" );
    $headers=  sprintf("Reply-To:%s", $email . "\r\n") ;
    $headers=  sprintf("X-Mailer: PHP/%s" , phpversion())     ;
    $fullMessage = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    if (mail($to, $subject, $fullMessage, $headers)) {
    } else {
        echo json_encode(array('status'=>0,'message'=>'Email sent Failed.Try again Later'));
    }
} else {
    $response['message'] = 'There is a problem';
}

?>
