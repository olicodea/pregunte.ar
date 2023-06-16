<?php

class sessionController
{
    public function cerrarSesion() {
        session_unset();
        header("Location: /home");
        exit();
    }
}