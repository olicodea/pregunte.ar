<?php

class RegistroController
{
    private $registroModel;
    private $renderer;

    private $mailer;

    public function __construct($registroModel, $renderer, $mailer)
    {
        $this->renderer = $renderer;
        $this->registroModel = $registroModel;
        $this->mailer = $mailer;
    }

    public function list()
    {
        $data["errorMsgRegistro"] = $_SESSION["errorMsgRegistro"] ?? null;
        $data["NotifMailEnviado"] = $_SESSION["NotifMailEnviado"] ?? null;

        $this->renderer->render("registro", $data);
        unset($_SESSION["errorMsgRegistro"]);

        if(isset($_SESSION["NotifMailEnviado"])) {
            session_unset();
        }
    }

    public function guardar()
    {
        if(!isset($_SESSION["DatosUsuario"]) || !isset($_SESSION["DatosLogin"])) {
            $_SESSION["errorMsgRegistro"] = $this->registroModel->getMensajeErrorRegistro();
            header("Location: /registro");
            exit();
        }
        unset($_SESSION["errorMsgRegistro"]);

        list($pais, $ciudad) = $this->registroModel->getPaisCiudadPorSeparado($_SESSION["DatosUsuario"]["PaisCiudad"]);

        $passwordHasheada = $this->registroModel->asegurarPassword($_SESSION["DatosLogin"]["Password"]);
        $rolInicial = $this->registroModel->getRolInicial();

        $datosRegistro = [
            $_SESSION["DatosUsuario"]["NombreCompleto"],
            $_SESSION["DatosUsuario"]["FechaNacimiento"],
            $_SESSION["DatosUsuario"]["Sexo"],
            $pais,
            $ciudad,
            $_SESSION["DatosLogin"]["Mail"],
            $_SESSION["DatosLogin"]["NombreUsuario"],
            $passwordHasheada,
            $_SESSION["DatosLogin"]["FotoPerfil"],
            $rolInicial
        ];

        $codigoValidacion = $this->registroModel->guardarYRetornarCodigoDeValidacion($datosRegistro, $_SESSION["DatosLogin"]["NombreUsuario"]);

        $datosCorreo = [
            "address" => $_SESSION["DatosLogin"]["Mail"],
            "addressName" => $_SESSION["DatosUsuario"]["NombreCompleto"],
            "subject" => $this->registroModel->getMailValidacionSubject(),
            "body" => $this->registroModel->getMailValidacionMessage($codigoValidacion)
        ];

        $mail = $this->mailer->enviarCorreoValidacion($datosCorreo["address"], $datosCorreo["addressName"], $datosCorreo["subject"], $datosCorreo["body"]);

        if($codigoValidacion && $mail) {
            $_SESSION["NotifMailEnviado"] = $this->registroModel->getMensajeMailEnviado();
        }

        header("Location: /registro");
    }
}