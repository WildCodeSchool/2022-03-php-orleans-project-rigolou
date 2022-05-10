<?php

namespace App\Controller;

use App\Model\RateManager;
use App\Model\AmusementManager;

class HomeController extends AbstractController
{
    public const MAX_CARDS_AMUSEMENT = 4;
    /**
     * Display home page
     */
    public function index(): string
    {
        $rateManager = new RateManager();
        $rates = $rateManager->selectAllStandardRate();

        $amusementManager = new AmusementManager();
        $amusements = $amusementManager->selectAll();
        $amusementsFourRandom = [];

        $amusementsNumber = count($amusements);
        if ($amusementsNumber > 0) {
            if ($amusementsNumber > self::MAX_CARDS_AMUSEMENT) {
                $amusementsNumber = self::MAX_CARDS_AMUSEMENT;
            }

            $amusementsRandKey = array_rand($amusements, $amusementsNumber);
            $amusementsFourRandom = array_intersect_key($amusements, array_flip($amusementsRandKey));
        }
        return $this->twig->render('Home/index.html.twig', [
            'amusements' => $amusementsFourRandom,
            'rates' => $rates,
        ]);
    }
}
