<?php

namespace App\Controller;

use App\Model\AnniversaryManager;

class AdminAnniversaryController extends AbstractController
{
    public function index(): string
    {
        $anniversaryManager = new AnniversaryManager();
        $anniversaryItems = $anniversaryManager->selectAll('reservation_date', 'DESC');

        return $this->twig->render('Admin/Anniversary/index.html.twig', ['anniversaryItems' => $anniversaryItems]);
    }
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $reservationManager = new AnniversaryManager();
            $reservation = $reservationManager->selectOneById((int) $id);

            if (!empty($reservation)) {
                $reservationManager->delete((int)$id);

                header('Location: /admin/reservations');
            }
        }
    }
}
