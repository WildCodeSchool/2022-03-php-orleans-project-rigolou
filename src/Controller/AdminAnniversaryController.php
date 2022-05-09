<?php

namespace App\Controller;

use App\Model\AnniversaryManager;
use App\Model\RateManager;

class AdminAnniversaryController extends AbstractController
{
    public function index(): string
    {

        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $anniversaryManager = new AnniversaryManager();
        $reservations = $anniversaryManager->selectAll('reservation_date', 'DESC');

        return $this->twig->render('Admin/Anniversary/index.html.twig', ['reservations' => $reservations]);
    }

    public function details(int $id): string
    {

        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $reservationManager = new AnniversaryManager();
        $reservation = $reservationManager->selectOneById($id);
        $rateManager = new RateManager();
        $anniversaryRates = $rateManager->selectAll();
        $titre = $anniversaryRates[$reservation['rate_id']];
        return $this->twig->render('Admin/Anniversary/details.html.twig', [
            'reservation' => $reservation,
            'anniversaryRates' => $anniversaryRates,
            'titre' => $titre,
        ]);
    }

    public function confirm()
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reservation = array_map('trim', $_POST);
            $comfirmManager = new AnniversaryManager();
            $comfirmManager->confirm($reservation['bool'], $reservation['id']);
            header('Location: /admin/reservations');
            return '';
        }
    }
}
