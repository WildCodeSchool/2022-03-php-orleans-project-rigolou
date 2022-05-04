<?php

namespace App\Controller;

use App\Model\AnniversaryDetailsManager;
use App\Model\RateManager;

class AdminAnniversaryDetailController extends AbstractController
{
    public function index(): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }
        $rateManager = new RateManager();
        $anniversaryRates = $rateManager->selectAllAnniversaryRate();

        $detailsManager = new AnniversaryDetailsManager();
        $anniversaryDetails = $detailsManager->selectAll();
        return $this->twig->render('Admin/AnniversaryDetail/index.html.twig', [
            'anniversaryRates' => $anniversaryRates,
            'anniversaryDetails' => $anniversaryDetails,
        ]);
    }
}
