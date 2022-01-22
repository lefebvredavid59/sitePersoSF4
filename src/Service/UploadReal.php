<?php


namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Realisation;


class UploadReal
{
    private $uploadDirReal;

    public function __construct($uploadDirReal)
    {
        $this->uploadDirReal = $uploadDirReal;
    }

    /**
     * $fileName = $this->uploader->upload($file);
     */
    public function upload(UploadedFile $image, Realisation $realisation)
    {
        // genere le nom de l'image
        $fileName = $realisation->getName().'.'.$image->guessExtension();
        // Deplace l'image
        $image->move($this->uploadDirReal, $fileName);

        return $fileName;
    }

    public function remove($fileName)
    {
        $fs = new Filesystem();
        // Supprimer le fichier
        $file = $this->uploadDirReal.'/'.$fileName;

        if ($fs->exists($file)){
            $fs->remove($file);
        }
    }
}