<?php

require 'interfaces/emailProvider.php';

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
        return true;
    }
}