<?php

namespace App\Controller;

use App\Model\AnniversaryDetailsManager;

class AnniversaryController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {

        $detailsManager = new AnniversaryDetailsManager();
        $details = $detailsManager->selectAll();
        return $this->twig->render('Anniversary/index.html.twig', ['details', $details]);
    }
}
