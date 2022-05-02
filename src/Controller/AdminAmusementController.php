<?php

namespace App\Controller;

use App\Model\AmusementManager;

class AdminAmusementController extends AbstractController
{
    public function index(): string
    {
        $amusementManager = new AmusementManager();
        $amusementItems = $amusementManager->selectAll('name');

        return $this->twig->render('Admin/Amusement/index.html.twig', ['amusementItems' => $amusementItems]);
    }
}
