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

    public function add(int $rate)
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $detailsManager = new AnniversaryDetailsManager();
        $details = $detailsManager->selectAllByRateId($rate);
        if (!empty($details)) {
            return $this->twig->render('Admin/AnniversaryDetail/add.html.twig', [
                'details' => $details,
            ]);
        }
        header('Location: /admin/anniversaire');
    }
}
