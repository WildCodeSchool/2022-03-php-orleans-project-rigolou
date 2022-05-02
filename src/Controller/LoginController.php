<?php

namespace App\Controller;

use App\Model\UserManager;

class LoginController extends AbstractController
{
    public function login(): string
    {
        return $this->twig->render('Login/login.html.twig');
    }

    public function logout()
    {
        if (!empty($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        header('Location: /');
    }
}
