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
        $amusements = $amusementManager->selectAll();
        $amusementsRandKey = array_rand($amusements, 4);
        $amusementsFourRandom = array_intersect_key($amusements, array_flip($amusementsRandKey));
        return $this->twig->render('Home/index.html.twig', [
            'amusements' => $amusementsFourRandom
        ]);
    }
}
