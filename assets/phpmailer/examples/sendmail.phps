<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>PHPMailer - sendmail test</title>
</head>
<body>
<?php
require 'inc/phpmailer/class.phpmailer.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
// Set PHPMailer to use the sendmail transport
$mail->IsSendmail();
//Set who the message is to be sent from
$mail->SetFrom('ranjeetshukla385@gmail.com', 'ranjeet shukla');
//Set an alternative reply-to address
$mail->AddReplyTo('ranjeetshukla385@gmail.com','ranjeet shukla');
//Set who the message is to be sent to
$mail->AddAddress('ranjeetshukla@sify.com', 'John Doe');
//Set the subject line
$mail->Subject = 'PHPMailer sendmail test hello';
//Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
$mail->MsgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$mail->
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
$mail->AddAttachment('newattachment.zip');

//Send the message, check for errors
if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
?>
</body>
</html>
