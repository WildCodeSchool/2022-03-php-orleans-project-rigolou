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
}
