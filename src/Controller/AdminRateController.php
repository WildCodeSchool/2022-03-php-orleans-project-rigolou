<?php

namespace App\Controller;

use App\Model\RateManager;

class AdminRateController extends AbstractController
{
    public function index(): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $rateManager = new RateManager();
        $rateItems = $rateManager->selectAllByCategory();

        return $this->twig->render('Admin/Rate/index.html.twig', [
            'rateItems' => $rateItems,
        ]);
    }

    public function add(): string
    {
        $rateManager = new RateManager();
        $categories = $rateManager->selectAllRateCategory();

        $rates = $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rates = array_map('trim', $_POST);
            $errors = $this->validateForm($rates, $categories);

            if (empty($errors)) {
                $rateManager = new RateManager();
                $rateManager->insert($rates);

                header('Location: /admin/tarifs');
            }
        }
        return $this->twig->render('Admin/Rate/add.html.twig', [
            'categories' => $categories,
            'rates' => $rates,
            'errors' => $errors,
        ]);
    }

    public function edit(int $id)
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $rates = $errors = [];
        $rateManager = new RateManager();
        $rates = $rateManager->selectOneById($id);
        $categories = $rateManager->selectAllRateCategory();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($rates)) {
            $rates = array_map('trim', $_POST);
            $errors = $this->validateForm($rates, $categories);

            if (empty($errors)) {
                $rates['id'] = $id;
                $rateManager->update($rates);
                header('Location: /admin/tarifs');
            }
        }

        return $this->twig->render('Admin/Rate/edit.html.twig', [
            'categories' => $categories,
            'rates' => $rates,
            'errors' => $errors,
        ]);
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
