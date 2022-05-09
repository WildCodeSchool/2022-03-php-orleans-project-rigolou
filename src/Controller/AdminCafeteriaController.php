<?php

namespace App\Controller;

use App\Model\CafeteriaManager;

class AdminCafeteriaController extends AbstractController
{
    public const ALLOWED_CATEGORIES = ['drink' => 'Boisson', 'snack' => 'Encas'];

    public function index(): string
    {
        $cafeteriatManager = new CafeteriaManager();
        $cafeteria = $cafeteriatManager->selectAll('name');

        return $this->twig->render('Admin/Cafeteria/index.html.twig', ['cafeteriaItems' => $cafeteria]);
    }

    public function add(): ?string
    {
        $cafeteria = $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cafeteria = array_map('trim', $_POST);
            $errors = $this->validate($cafeteria);
            if (empty($errors)) {
                $cafeteriaManager = new CafeteriaManager();
                $cafeteriaManager->insert($cafeteria);
                header('Location: /admin/cafeteria');
            }
        }
        return $this->twig->render('Admin/Cafeteria/add.html.twig', [
            'errors' => $errors,
            'cafeteria' => $cafeteria,
            'allowedCategories' => self::ALLOWED_CATEGORIES,
        ]);
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

        if (empty($cafeteria['price']) && !is_numeric($cafeteria['price']) && $cafeteria['price'] > 0) {
            $errors[] = 'Le prix est obligatoire et doit être un nombre supérieur à 0';
        }

        if (!array_key_exists($cafeteria['category'], self::ALLOWED_CATEGORIES)) {
            $errors[] = 'La catégorie choisie ne correspond pas';
        }

        return $errors;
    }

    public function edit(int $id): ?string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }
        $cafeteria = $errors = [];
        $cafeteriaManager = new CafeteriaManager();
        $cafeteria = $cafeteriaManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cafeteria = array_map('trim', $_POST);
            $errors = $this->validate($cafeteria);

            if (empty($errors)) {
                $cafeteriaManager = new CafeteriaManager();
                $cafeteriaManager->update($cafeteria);
                header('Location: /admin/cafeteria');
            }
        }
        return $this->twig->render('Admin/Cafeteria/edit.html.twig', [
            'errors' => $errors,
            'cafeteria' => $cafeteria,
            'allowedCategories' => self::ALLOWED_CATEGORIES,
        ]);
  
    public function delete()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            if ($id > 0) {
                $cafeteriaManager = new CafeteriaManager();
                $cafeteria = $cafeteriaManager->selectOneById((int) $id);

                if (!empty($cafeteria)) {
                    $cafeteriaManager->delete((int)$id);
                }
            }
        }
        header('Location: /admin/cafeteria');
    }
}
