<?php

namespace App\Controller;

class AdminRateController extends AbstractController
{
    public function index(): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }
        return $this->twig->render('Admin/Rate/index.html.twig');
    }
}
