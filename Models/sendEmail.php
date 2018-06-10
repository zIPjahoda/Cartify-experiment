<?php

/**
 * Created by PhpStorm.
 * User: zidan
 * Date: 29.2.2016
 * Time: 17:57
 */
class sendEmail
{
    /**
     * @param $whom string; Pro koho
     * @param $subject string; Nadpis emailu
     * @param $message string; obsah zpravy
     * @param $from string; Od koho email
     * @return bool
     */
    public function send($whom,$subject, $message, $from)
    {
        $header = "From: " . $from;
        $header .="\nMine-Version: 1.0\n";
        $header .="Content-Type: text/html; charset=\"utf-8\"\n";
        return mb_send_mail($whom,$subject, $message, $header);

    }

    public function sendAntispameror($years, $whom, $subject, $message, $from){
        if($years != date("Y"))
            throw new errorUser('Chybne vyplnene heslo');
        $this->send($whom,$subject, $message, $from);
    }
}