<?php

namespace App\Controller;

use App\Model\AnniversaryManager;

class AnniversaryController extends AbstractController
{
    public function index()
    {
        $errors = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reservation = array_map('trim', $_POST);
            $errors = $this->validate($reservation);
        }
        return $this->twig->render('Anniversary/index.html.twig', ['errors' => $errors]);
    }

    public function validate(array $reservation): array
    {

        $errors = [];
        if (empty($reservation['firstname'])) {
            $errors[] = 'Le prénom est obligatoire';
        }

        if (empty($reservation['lastname'])) {
            $errors[] = 'Le nom est obligatoire';
        }

        if (empty($reservation['email'])) {
            $errors[] = 'L\'e-mail est obligatoire';
        } elseif (!filter_var($reservation['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'L\'e-mail n\'a pas le bon format';
        }

        if (empty($reservation['message'])) {
            $errors[] = 'Le message est obligatoire';
        }

        if (empty($reservation['date'])) {
            $errors[] = 'La date est obligatoire';
        }

        if (empty($reservation['phone'])) {
            $errors[] = 'Le numéro de téléphone est obligatoire';
        }
        return $errors;
    }
}
