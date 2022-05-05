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
}
