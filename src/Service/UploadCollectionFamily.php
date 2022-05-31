<?php


namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class UploadCollectionFamily
{
    private $uploadCollectionFamily;

    public function __construct($uploadCollectionFamily)
    {
        $this->UploadCollectionFamily = $uploadCollectionFamily;
    }

    /**
     * $fileName = $this->uploader->upload($file);
     */
    public function upload(UploadedFile $image)
    {
        // genere le nom de l'image
        $fileName = uniqid().'.'.$image->guessExtension();
        // Deplace l'image
        $image->move($this->UploadCollectionFamily, $fileName);

        return $fileName;
    }

    public function remove($fileName)
    {
        $fs = new Filesystem();
        // Supprimer le fichier
        $file = $this->UploadCollectionFamily.'/'.$fileName;

        if ($fs->exists($file)){
            $fs->remove($file);
        }
    }
}