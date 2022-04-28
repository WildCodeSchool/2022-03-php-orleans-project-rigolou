<?php

namespace App\Controller;

use App\Model\AnniversaryDetailsManager;
use App\Model\RateManager;

class AnniversaryController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $rateManager = new RateManager();
        $anniversaryRates = $rateManager->selectAllAnniversary();
        $detailsManager = new AnniversaryDetailsManager();
        $details = $detailsManager->selectAll('rate_id');
        return $this->twig->render('Anniversary/index.html.twig', [
            'anniversaryRates' => $anniversaryRates,
            'details' => $details,
        ]);
    }
}
