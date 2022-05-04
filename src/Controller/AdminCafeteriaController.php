<?php

namespace App\Controller;

use App\Model\CafeteriaManager;

class AdminCafeteriaController extends AbstractController
{
    public function index(): string
    {
        $cafeteriatManager = new CafeteriaManager();
        $cafeteriaItems = $cafeteriatManager->selectAll('name');

        return $this->twig->render('Admin/Cafeteria/index.html.twig', ['cafeteriaItems' => $cafeteriaItems]);
    }
}
