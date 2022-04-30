<?php

namespace App\Controller;

use App\Model\AmusementManager;

class AdminAmusementController extends AbstractController
{
    public const AUTHORIZED_MIMES = ['image/jpeg','image/png', 'image/webp', 'image/gif'];

    public function index(): string
    {
        $amusementsManager = new AmusementManager();
        $amusements = $amusementsManager->selectAll('name');

        return $this->twig->render('Admin/Amusement/index.html.twig', ['amusements' => $amusements]);
    }

    public function add(): string
    {
        $amusementItems = $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amusementItems = array_map('trim', $_POST);
            $errorsText = $this->textValidate($amusementItems);
            $errorsImage = $this->imageValidate();

            $errors = [...$errorsText, ...$errorsImage];

            //if we do empty($errors) GrumPHP is not happy: Variable $errors in empty() always exists and is not falsy.
            if (empty($errorsText) && empty($errorsImage)) {
                $randomImageName = uniqid('', true) . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], APP_UPLOAD_LOCALE_PATH . $randomImageName);
                $amusementItems['image'] = $randomImageName;

                $amusementManager = new amusementManager();
                $amusementManager->insert($amusementItems);

                header('Location: /admin/attractions/');
            }
        }
        return $this->twig->render('Admin/Amusement/add.html.twig', [
            'errors' => $errors,
            'amusementItems' => $amusementItems,
        ]);
    }

    public function textValidate(array $amusementItems): array
    {
        $errors = [];
        if (empty($amusementItems['name'])) {
            $errors[] = 'Le nom est obligatoire';
        }

        $nameMaxLength = 100;
        if (strlen($amusementItems['name']) > $nameMaxLength) {
            $errors[] = 'Le nom ne doit pas dépasser ' . $nameMaxLength . ' caractères';
        }

        if (empty($amusementItems['description'])) {
            $errors[] = 'La description est obligatoire';
        }

        return $errors;
    }

    public function imageValidate(): array
    {
        $errors = [];
        if (file_exists($_FILES['image']['tmp_name'])) {
            if (!in_array(mime_content_type($_FILES['image']['tmp_name']), self::AUTHORIZED_MIMES)) {
                $errors[] = 'Le format de l\'image n\'est pas valide';
            }

            $maxFileSize = 1000000;
            if (filesize($_FILES['image']['tmp_name']) > $maxFileSize) {
                $errors[] = 'L\'image doit faire moins de ' . $maxFileSize / 1000000 . 'mo';
            }
        } else {
            $errors[] = 'L\'image est obligatoire';
        }

        return $errors;
    }
}
