<?php
namespace App\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class RickAndMortyManager{
    public function load (UploadedFile $file, string $destino){
        $fileName=uniqid().'.'.$file->guessClientExtension();
        $file->move($destino, $fileName);
        return $fileName;

    }
}