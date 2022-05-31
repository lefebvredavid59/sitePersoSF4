<?php


namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Article;


class UploadCollectionEdition
{
    private $uploadCollectionEdition;

    public function __construct($uploadCollectionEdition)
    {
        $this->uploadCollectionEdition = $uploadCollectionEdition;
    }

    /**
     * $fileName = $this->uploader->upload($file);
     */
    public function upload(UploadedFile $image)
    {
        // genere le nom de l'image
        $fileName = uniqid().'.'.$image->guessExtension();
        // Deplace l'image
        $image->move($this->uploadCollectionEdition, $fileName);

        return $fileName;
    }

    public function remove($fileName)
    {
        $fs = new Filesystem();
        // Supprimer le fichier
        $file = $this->uploadCollectionEdition.'/'.$fileName;

        if ($fs->exists($file)){
            $fs->remove($file);
        }
    }
}