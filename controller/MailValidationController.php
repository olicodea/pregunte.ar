<?php

class MailValidationController
{

    private $mailValidationModel;
    private $userModel;
    private $renderer;

    public function __construct($mailValidationModel,$usarModel, $renderer) {
        $this->mailValidationModel = $mailValidationModel;
        $this->userModel = $usarModel;
        $this->renderer = $renderer;
    }

    public function list() {
        $data["validationConfirmed"] = $_SESSION["validationConfirmed"] ?? null;
        $this->renderer->render("validation", $data);
    }

    public function validate(){
        if(isset($_GET['codigo'])){
            $validationCode = $_GET['codigo'];
            $validations = $this->mailValidationModel->getValidation($validationCode);
            if($validations && mysqli_num_rows($validations) > 0) {
                $validation = mysqli_fetch_assoc($validations);
                $this->userModel->validateUserMail($validation["idUsuario"]);
                $validationConfirmed = $this->mailValidationModel->deleteValidation($validation["idUsuario"]);
                $_SESSION["validationConfirmed"] = $validationConfirmed;
            }
            header("Location: /mailValidation");
        }
    }
}