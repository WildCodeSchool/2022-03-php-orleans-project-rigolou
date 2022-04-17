<?php

namespace App\Controller;

use App\Model\RateManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $rateManager = new RateManager();
        $rates = $rateManager->selectAll('category != \'Anniversaire\'');

        $rates[] = ['description' => 'Formules anniversaire', 'price' => 'Voir la page dédiée'];

        return $this->twig->render('Home/index.html.twig', ['rates' => $rates]);
    }
}
