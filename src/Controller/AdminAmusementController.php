<?php

namespace App\Controller;

use App\Model\AmusementManager;

class AdminAmusementController extends AbstractController
{
    public const AUTHORIZED_MIMES = ['image/jpeg','image/png', 'image/webp', 'image/gif'];

    public function index(): string
    {
        $amusementManager = new AmusementManager();
        $amusementItems = $amusementManager->selectAll('name');

        return $this->twig->render('Admin/Amusement/index.html.twig', ['amusementItems' => $amusementItems]);
    }

    public function add(): string
    {
        $amusementItems = $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amusementItems = array_map('trim', $_POST);
            $errorsText = $this->textValidate($amusementItems);
            $errorsImage = [];
            if (file_exists($_FILES['image']['tmp_name'])) {
                $errorsImage = ImageController::validateImage();
            } else {
                $errorsImage[] = 'L\'image est obligatoire';
            }

            $errors = [...$errorsText, ...$errorsImage];

            //if we do empty($errors) GrumPHP is not happy: Variable $errors in empty() always exists and is not falsy.
            if (empty($errorsText) && empty($errorsImage)) {
                $randomImageName = uniqid('', true) . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['image']['tmp_name'], APP_UPLOAD_LOCAL_PATH . $randomImageName);
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

    private function textValidate(array $amusementItems): array
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
}
