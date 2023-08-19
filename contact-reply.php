<?php
include('include/config.php');

require_once('SMTP.php');
require_once('PHPMailer.php');
require_once('Exception.php');

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

$remark = $_POST['adminremark'];
$email = $_POST['email'];
$isread=1;
$con->query("UPDATE tblcontactus set AdminRemark='$remark',IsRead='$isread' where email = '$email'");

$mail=new PHPMailer(true); // Passing `true` enables exceptions

try {
    //settings
    $mail->SMTPDebug=2; // Enable verbose debug output
    $mail->isSMTP(); // Set mailer to use SMTP
    $mail->Host='smtp.gmail.com';
    $mail->SMTPAuth=true; // Enable SMTP authentication
    $mail->Username='kidstvminiproject@gmail.com'; // SMTP username
    $mail->Password='tesgtsikebbzjybb'; // SMTP password
    $mail->SMTPSecure='ssl';
    $mail->Port=465;

    $mail->setFrom('support@kidstv.com', 'KidsTv');

    //recipient
    $mail->addAddress($email);     // Add a recipient

    //content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject='New password for Classroom Connection';
    $mail->Body='Hi '.$remark.$email;
    $mail->AltBody='There is an error please contact admin';

    $mail->send();

    setcookie('Success', 'Mail Successfully Sent...', time() + (5), "/");
    header('location: read-query.php');
}
catch(Exception $e) {
    setcookie('error', 'Mail Could Not Be Sent...', time() + (5), "/");
    header('location: read-query.php');
}

?>