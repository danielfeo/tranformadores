<?php

require 'interfaces/emailProvider.php';
require 'PHPMailerAutoload.php';


/**
 * This example shows making an SMTP connection with authentication.
 */
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that


class JMail implements emailProvider{

    public function __construct($host, $user, $pass, $port, $status){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->port = $port;
        $this->status = $status;
    }

    public function send($from, $to, $subject, $message)
    {
        date_default_timezone_set('Etc/UTC');

        
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;
        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
        //Set the hostname of the mail server
        $mail->Host = $this->host;
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = $this->port;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication
        $mail->Username =  $this->user;
        //Password to use for SMTP authentication
        $mail->Password =  $this->pass;
        //Set who the message is to be sent from
        $mail->setFrom('web@redeamerica.org', 'Redeamerica');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
        $mail->addAddress($to, $to);
        //Set the subject line
        $mail->Subject = $subject;
        //Replace the plain text body with one created manually
        $mail->msgHTML($message);
        //$mail->AltBody =  $message;
        //Attach an image file
               //send the message, check for errors
        if (!$mail->send()) {
            echo 'error '. $mail->ErrorInfo;
        } else {
            return true;
        }
    }
}