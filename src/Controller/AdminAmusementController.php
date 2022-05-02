<?php

namespace App\Controller;

use App\Model\AmusementManager;

class AdminAmusementController extends AbstractController
{
    public function index(): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $amusementManager = new AmusementManager();
        $amusementItems = $amusementManager->selectAll('name');

        return $this->twig->render('Admin/Amusement/index.html.twig', ['amusementItems' => $amusementItems]);
    }
}
