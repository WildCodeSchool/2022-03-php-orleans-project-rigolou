<?php

namespace App\Controller;

use App\Model\CafeteriaManager;

class CafeteriaController extends AbstractController
{
    public function index(): string
    {
        $cafeteriaManager = new CafeteriaManager();
        $drinks = $cafeteriaManager->selectByCategory(CafeteriaManager::DRINK);
        $snacks = $cafeteriaManager->selectByCategory(CafeteriaManager::SNACKS);

        return $this->twig->render('Cafeteria/index.html.twig', ['boissons' => $drinks, 'snacks' => $snacks]);
    }
}
