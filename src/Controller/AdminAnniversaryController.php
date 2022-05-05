<?php

namespace App\Controller;

use App\Model\AnniversaryManager;
use App\Model\RateManager;

class AdminAnniversaryController extends AbstractController
{
    public function index(): string
    {
        $anniversaryManager = new AnniversaryManager();
        $anniversaryItems = $anniversaryManager->selectAll('reservation_date', 'DESC');

        return $this->twig->render('Admin/Anniversary/index.html.twig', ['anniversaryItems' => $anniversaryItems]);
    }

    public function details(int $id): string
    {
        $reservationManager = new AnniversaryManager();
        $reservation = $reservationManager->selectOneById($id);
        $rateManager = new RateManager();
        $anniversaryRates = $rateManager->selectAll();
        $titre = $anniversaryRates [$reservation['rate_id']];
        return $this->twig->render('Admin/Anniversary/details.html.twig', [
            'reservation' => $reservation,
            'anniversaryRates' => $anniversaryRates,
            'titre' => $titre,
        ]);
    }
}
