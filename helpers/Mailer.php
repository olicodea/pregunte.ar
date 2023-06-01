<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{
    private $mail;
    private $from;
    private $fromName;

    public function __construct($mail, $host, $SMTPAuth, $username, $password, $port, $from, $fromName){
        $this->mail = $mail;
        $this->mail->isSMTP();
        $this->mail->Host = $host;
        $this->mail->SMTPAuth = $SMTPAuth;
        $this->mail->Username = $username;
        $this->mail->Password = $password;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = $port;

        $this->from = $from;
        $this->fromName = $fromName;
    }

    public function enviarCorreoValidacion($address, $addressName, $subject, $body) {
        return $this->enviarCorreo($this->from, $this->fromName, $address, $addressName, $subject, $body);
    }

    public function enviarCorreo($from, $fromName, $address, $addressName, $subject, $body) {
        try {
            $this->mail->setFrom($from, $fromName);
            $this->mail->addAddress($address, $addressName);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->send();

            return "Mail enviado correctamente";
        } catch (Exception $e) {
            return "Error: " . $this->mail->ErrorInfo;
        }
    }
}