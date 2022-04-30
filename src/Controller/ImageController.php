<?php

namespace App\Controller;

class ImageController
{
    public const AUTHORIZED_MIMES = ['image/jpeg','image/png', 'image/webp', 'image/gif'];

    public static function validateImage(): array
    {
        $errors = [];
        if (!in_array(mime_content_type($_FILES['image']['tmp_name']), self::AUTHORIZED_MIMES)) {
            $errors[] = 'Le format de l\'image n\'est pas valide';
        }

        $maxFileSize = 1000000;
        if (filesize($_FILES['image']['tmp_name']) > $maxFileSize) {
            $errors[] = 'L\'image doit faire moins de ' . $maxFileSize / 1000000 . 'mo';
        }
        return $errors;
    }
}
