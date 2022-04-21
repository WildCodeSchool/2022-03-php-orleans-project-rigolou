<?php

namespace App\Controller;

use App\Model\AmusementManager;

class AmusementsController extends AbstractController
{
    public function index(): string
    {
        $amusementsManager = new AmusementManager();
        $amusements = $amusementsManager->selectAll('name');

        return $this->twig->render('Amusements/index.html.twig', ['amusements' => $amusements]);
    }
}
