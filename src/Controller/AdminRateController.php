<?php

namespace App\Controller;

use App\Model\RateManager;

class AdminRateController extends AbstractController
{
    public function index(string $msg = ''): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }
        $error = '';
        if ($msg === 'wrongEditId') {
            $error = 'Le tarif n\'éxiste pas';
        }

        $rateManager = new RateManager();
        $rateItems = $rateManager->selectAllByCategory();
        return $this->twig->render('Admin/Rate/index.html.twig', [
            'rateItems' => $rateItems,
            'error' => $error,
        ]);
    }

    public function add(): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $rateManager = new RateManager();
        $categories = $rateManager->selectAllRateCategory();

        $rate = $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rate = array_map('trim', $_POST);
            $errors = $this->validateForm($rate, $categories);

            if (empty($errors)) {
                $rateManager = new RateManager();
                $rateManager->insert($rate);

                header('Location: /admin/tarifs');
            }
        }
        return $this->twig->render('Admin/Rate/add.html.twig', [
            'categories' => $categories,
            'rate' => $rate,
            'errors' => $errors,
        ]);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $rateManager = new RateManager();
            $rate = $rateManager->selectOneById((int) $id);

            if (!empty($rate)) {
                $rateManager->delete((int)$id);
            }
        }
        header('Location: /admin/tarifs');
    }

    public function edit(int $id): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $id = trim((string)$id);
        $rateManager = new RateManager();
        $rate = $rateManager->selectOneById((int)$id);
        if (!empty($rate)) {
            $categories = $rateManager->selectAllRateCategory();
            $errors = [];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $rate = array_map('trim', $_POST);
                $errors = $this->validateForm($rate, $categories);

                if (empty($errors)) {
                    $rate['id'] = $id;
                    $rateManager = new RateManager();
                    $rateManager->update($rate);

                    header('Location: /admin/tarifs');
                }
            }
            return $this->twig->render('Admin/Rate/edit.html.twig', [
                'categories' => $categories,
                'rate' => $rate,
                'errors' => $errors,
            ]);
        }
        header('Location: /admin/tarifs?msg=wrongEditId');
        return '';
    }

    private function validateForm(array $ratesPost, array $categories): array
    {
        $errors = [];
        if (empty($ratesPost['category'])) {
            $errors[] = 'La catégorie est obligatoire';
        } elseif (!in_array($ratesPost['category'], array_column($categories, 'id'))) {
            $errors[] = 'La catégorie n\'est pas valide';
        }

        $descriptionMaxLength = 100;
        if (empty($ratesPost['description'])) {
            $errors[] = 'La description est obligatoire';
        } elseif (strlen($ratesPost['description']) > $descriptionMaxLength) {
            $errors[] = 'La description ne doit pas dépasser ' . $descriptionMaxLength . ' caractères';
        }

        $priceMaxLength = 100;
        if (empty($ratesPost['price'])) {
            $errors[] = 'La prix est obligatoire';
        } elseif (strlen($ratesPost['price']) > $priceMaxLength) {
            $errors[] = 'Le prix ne doit pas dépasser ' . $priceMaxLength . ' caractères';
        }
        return $errors;
    }
}
