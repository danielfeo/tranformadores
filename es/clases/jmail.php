<?php

/*
require 'Mail.php';
require 'interfaces/emailProvider.php';

class JMail implements emailProvider{

     public function __construct($host, $user, $pass, $port, $status){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->port = $port;
        $this->status = $status;
     }

     public function send($from, $to, $subject, $message){
        $_from = "<".$from.">";
        $_to = "<".$to.">";
        $_subject =  $subject;
        $_body = $message;

        $host = $this->host;
        $username = $this->user;
        $password = $this->pass;

        $headers = array(
            'From' => 'redeamerica.org@web26.3essentials.com',
            'To' => $_to,
            'Subject' => $_subject
        );
        $smtp = Mail::factory('smtp', array (
            'host' => 'localhost',
            'port' => '25',
            'auth' => true,
            'username' => 'redeamerica.org@web26.3essentials.com',
            'password' => 'jXmKJhAdxSGp1PA'
        ));

        $mail = $smtp->send($to, $headers, $_body);

        if (PEAR::isError($mail)) {
            echo("<p>" . $mail->getMessage() . "</p>");
        } else {
            return true;
        }
     }
}
*/