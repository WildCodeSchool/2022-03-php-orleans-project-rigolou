<?php

namespace App\Controller;

use App\Model\CafeteriaManager;

class AdminCafeteriaController extends AbstractController
{
    public function index(): string
    {
        $cafeteriatManager = new CafeteriaManager();
        $cafeteria = $cafeteriatManager->selectAll('name');
        // $cafeteriaItems ??

        return $this->twig->render('Admin/Cafeteria/index.html.twig', ['cafeteriaItems' => $cafeteria]);
    }

    public function add(): ?string
    {
        $cafeteria = $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $cafeteria = array_map('trim', $_POST);
            $errors = $this->validate($cafeteria);
            // TODO validations (length, format...)
            if (empty($errors)) {
                // if validation is ok, insert and redirection
                $cafeteriaManager = new CafeteriaManager();
                $cafeteriaManager->insert($cafeteria);
                header('Location: /admin/cafeteria');
            }
        }

        return $this->twig->render('Admin/Cafeteria/add.html.twig', ['errors' => $errors]);
    }

    private function validate(array $cafeteria): array
    {
        $errors = [];
        if (empty($cafeteria['name'])) {
            $errors[] = 'Le nom est obligatoire';
        }

        $nameMaxLength = 100;
        if (strlen($cafeteria['name']) > $nameMaxLength) {
            $errors[] = 'Le nom ne doit pas dépasser ' . $nameMaxLength . ' caractères';
        }

        if (empty($cafeteria['price']) && !is_numeric($cafeteria['price'])) {
            $errors[] = 'La prix est obligatoire et doit être un nombre';
        }

        return $errors;
    }
}
