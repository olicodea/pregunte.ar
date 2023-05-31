<?php
class FileManager
{
    public function __construct() {
    }
    public function guardarImagen($file, $fileName) {
        $nombre_original = $file["name"];
        $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
        $imageURL = "public/image/" . $fileName . ".$extension";
        move_uploaded_file($file["tmp_name"], $imageURL);
        var_dump($imageURL);
        return $imageURL;
    }
}