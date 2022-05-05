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
        $anniversaryItems = $anniversaryManager->selectAll('reservation_date', 'DESC');

        return $this->twig->render('Admin/Anniversary/index.html.twig', ['anniversaryItems' => $anniversaryItems]);
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
            $inputs = array_map('trim', $_POST);
            if (
                empty($inputs['id']) ||
                (int)$inputs['bool'] > 1 ||
                (int)$inputs['bool'] < 0
            ) {
                header('Location: /admin/reservations');
                return '';
            }
            $comfirmManager = new AnniversaryManager();
            $comfirmManager->confirm($inputs['bool'], $inputs['id']);
            header('Location: /admin/reservations');
            return '';
        }
    }
}
