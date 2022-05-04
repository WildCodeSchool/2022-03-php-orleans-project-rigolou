<?php

namespace App\Controller;

use App\Model\AnniversaryManager;

class AdminAnniversaryDetailController extends AbstractController
{
    public function index(): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        return $this->twig->render('Admin/AnniversaryDetail/index.html.twig');
    }
}
