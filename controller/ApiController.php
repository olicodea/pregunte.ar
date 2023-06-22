<?php

class ApiController{

    private $apiModel;

    public function __construct($apiModel)
    {
        $this->apiModel = $apiModel;
    }

    public function preguntas(){
        $idCategoria = $_GET["id"];
        // if no $idcateogria return json vacio o erro

       $resultado = $this->apiModel->findPreguntasPorIdCategoria($idCategoria);

       // private methdo renderJson($json)
        header('Content-Type: application/json; charset=utf-8');
       echo json_encode($resultado);
    }
}