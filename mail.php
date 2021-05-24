<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "src/PHPMailer.php";
require_once "src/Exception.php";
require_once "src/OAuth.php";
require_once "src/POP3.php";
require_once "src/SMTP.php";

$mail = new PHPMailer;

//Enable SMTP debugging.
//$mail->SMTPDebug = 3;
//Set PHPMailer to use SMTP.
$mail->isSMTP();
//Set SMTP host name
$mail->Host = "srv116.niagahoster.com"; //host mail server (sesuaikan dengan mail hosting Anda)
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;
//Provide username and password
$mail->Username = "no_reply@wardrobe-purifier.net";   //nama-email smtp
$mail->Password = "adminwp123";           //password email smtp
//If SMTP requires TLS encryption then set it
//$mail->SMTPSecure = "ssl";
//Set TCP port to connect to
$mail->Port = 587;

$mail->From = "no_reply@wardrobe-purifier.net"; //email pengirim
$mail->FromName = "admin no-reply wardrobe-purifier"; //nama pengirim

$mail->addAddress("yuda_chandra@ymail.com");

$mail->isHTML(true);

$mail->Subject = "Confirm Registration";
        $mail->Body = "Your email registered on our portal application with UserName XXX
Please follow this link to set password and complete your registration"; //isi email
        $mail->AltBody = "PHP mailer"; //body email

if(!$mail->send())
{
    echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
    echo "Message has been sent successfully";
}

?>
