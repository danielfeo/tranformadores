<?php

interface emailProvider {
    public function send($from, $to, $subject, $message);
}