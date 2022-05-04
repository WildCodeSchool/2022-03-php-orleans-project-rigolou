<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    public function index(): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        return $this->twig->render('Admin/Home/index.html.twig');
    }
}
