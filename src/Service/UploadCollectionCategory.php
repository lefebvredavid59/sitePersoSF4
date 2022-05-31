<?php


namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Article;


class UploadCollectionCategory
{
    private $uploadDirCollectionCategory;

    public function __construct($uploadDirCollectionCategory)
    {
        $this->uploadDirCollectionCategory = $uploadDirCollectionCategory;
    }

    /**
     * $fileName = $this->uploader->upload($file);
     */
    public function upload(UploadedFile $image)
    {
        // genere le nom de l'image
        $fileName = uniqid().'.'.$image->guessExtension();
        // Deplace l'image
        $image->move($this->uploadDirCollectionCategory, $fileName);

        return $fileName;
    }

    public function remove($fileName)
    {
        $fs = new Filesystem();
        // Supprimer le fichier
        $file = $this->uploadDirCollectionCategory.'/'.$fileName;

        if ($fs->exists($file)){
            $fs->remove($file);
        }
    }
}