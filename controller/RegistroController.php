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
            session_destroy();
        }
    }

    public function guardar()
    {
        if(!isset($_SESSION["DatosUsuario"]) || !isset($_SESSION["DatosLogin"])) {
            $_SESSION["errorMsgRegistro"] = "Para registrarse es necesario completar todos los datos";
            header("Location: /registro");
            exit();
        }
        unset($_SESSION["errorMsgRegistro"]);

        list($pais, $ciudad) = explode(", ", $_SESSION["DatosUsuario"]["PaisCiudad"]);

        $passwordHasheada = md5($_SESSION["DatosLogin"]["Password"]);

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
            4 //Rol: NoValidado
        ];

        $codigoValidacion = $this->registroModel->guardar($datosRegistro, $_SESSION["DatosLogin"]["NombreUsuario"]);

        $datosCorreo = [
            "address" => $_SESSION["DatosLogin"]["Mail"],
            "addressName" => $_SESSION["DatosUsuario"]["NombreCompleto"],
            "subject" => $this->registroModel->getMailValidacionSubject(),
            "body" => $this->registroModel->getMailValidacionMessage($codigoValidacion)
        ];

        $mail = $this->mailer->enviarCorreoValidacion($datosCorreo["address"], $datosCorreo["addressName"], $datosCorreo["subject"], $datosCorreo["body"]);

        if($codigoValidacion && $mail) {
            $_SESSION["NotifMailEnviado"] = "El registro se realizó con éxito. Te enviamos un mail a " . $_SESSION["DatosLogin"]["Mail"] . " para validar la cuenta";
        }

        header("Location: /registro");
    }
}