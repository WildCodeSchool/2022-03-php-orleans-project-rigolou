<?php

namespace App\Controller;

use App\Model\UserManager;

class LoginController extends AbstractController
{
    public function login(): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $emailAndPassword = array_map('trim', $_POST);
            if (empty($emailAndPassword['email'])) {
                $errors[] = 'L\'email est obligatoire';
            }
            if (empty($emailAndPassword['password'])) {
                $errors[] = 'Le mot de passe est obligatoire';
            }
            if (!filter_var($emailAndPassword['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Le format d\'email est invalide';
            }

            if (empty($errors)) {
                $userManager = new UserManager();
                $user = $userManager->selectOneByEmail($emailAndPassword['email']);
                if ($user) {
                    if (password_verify($emailAndPassword['password'], $user['password'])) {
                        $_SESSION['user'] = $user['id'];
                        header('Location: /admin');
                    } else {
                        $errors[] = 'Mauvais mot de passe';
                    }
                } else {
                    $errors[] = 'Email inconnu';
                }
            }
        }
        return $this->twig->render('Login/login.html.twig', [
            'errors' => $errors,
        ]);
    }

    public function logout()
    {
        if (!empty($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        header('Location: /');
    }
}
