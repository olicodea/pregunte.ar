<?php

class LoginModel¨{
    private $databasde;

    publi function __contructor($database){
    $this->databasde = $database;
}
public function GetLogin() {
        return $this->databasde->query('SELECT * FROM usuarios');

}
}