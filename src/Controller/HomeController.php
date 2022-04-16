<?php

namespace App\Controller;

use App\Model\AmusementManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $amusementManager = new AmusementManager();
        $amusements = $amusementManager->selectFourRandom();
        return $this->twig->render('Home/index.html.twig', ['amusements' => $amusements]);
    }
}
