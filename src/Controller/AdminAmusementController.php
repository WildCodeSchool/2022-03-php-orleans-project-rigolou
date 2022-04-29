<?php

namespace App\Controller;

use App\Model\AmusementManager;

class AdminAmusementController extends AbstractController
{
    public function index(): string
    {
        $amusementsManager = new AmusementManager();
        $amusements = $amusementsManager->selectAll('name');

        return $this->twig->render('Admin/Amusement/index.html.twig', ['amusements' => $amusements]);
    }
}
