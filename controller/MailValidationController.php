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
        die("ListMethod is being build");
    }

    public function validate(){
        if(isset($_GET['validation'])){
            $validationCode = $_GET['validation'];
            $validations = $this->mailValidationModel->getValidation($validationCode);
            if($validations && mysqli_num_rows($validations)>0){
                $validation = mysqli_fetch_assoc($validations);
                $this->userModel->validateUserMail($validation["idUsuario"]);
                $data["validation"] = $validation;
                $this->renderer->render("validationDone", $data);
            }else{

                $data["validation"] = $validationCode;
                $this->renderer->render("validationFailed", $data);
            }

        }
    }
}