<?php

namespace App\Controller;

use App\Model\AnniversaryManager;

class AdminAnniversaryController extends AbstractController
{
    public function index(): string
    {
        $anniversaryManager = new AnniversaryManager();
        $anniversaryItems = $anniversaryManager->selectAll();

        return $this->twig->render('Admin/Anniversary/index.html.twig', ['anniversaryItems' => $anniversaryItems]);
    }
}
