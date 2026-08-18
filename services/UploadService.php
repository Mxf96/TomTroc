<?php

class UploadService
{
    /**
     * Enregistre une nouvelle photo de profil.
     */
    public function uploadAvatar(array $file): string
    {
        // Vérifie qu'un fichier a bien été envoyé.
        if (
            !isset($file['error'])
            || $file['error'] !== UPLOAD_ERR_OK
        ) {
            throw new Exception(
                "Une erreur est survenue lors de l'envoi de l'image."
            );
        }

        // Taille maximale : 2 Mo.
        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception(
                "L'image ne doit pas dépasser 2 Mo."
            );
        }

        // Vérification réelle du type MIME.
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        $mimeType = $finfo->file($file['tmp_name']);

        $allowedTypes = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg',
            'image/webp' => 'webp',
            'image/avif' => 'avif',
        ];


        if (!isset($allowedTypes[$mimeType])) {
            throw new Exception(
                "Format non autorisé. Formats acceptés : PNG, JPG, JPEG, WebP et AVIF."
            );
        }

        // Génération d'un nom unique.
        $extension = $allowedTypes[$mimeType];

        $fileName = 'avatar_' . bin2hex(random_bytes(16)) . '.' . $extension;

        // Dossier physique sur le serveur.
        $uploadDirectory = dirname(__DIR__) . '/assets/img/pictures/';


        if (!is_dir($uploadDirectory)) {
            throw new Exception(
                "Le dossier de destination est introuvable."
            );
        }

        $destination = $uploadDirectory . $fileName;


        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception(
                "Impossible d'enregistrer l'image."
            );
        }

        // Chemin qui sera enregistré dans la BDD.
        return './assets/img/pictures/' . $fileName;
    }
}