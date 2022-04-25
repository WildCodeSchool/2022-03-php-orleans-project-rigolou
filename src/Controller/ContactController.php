<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Display contact page
     */
    public function index(): string
    {
        $validations = $this->validateContactPost();

        return $this->twig->render('Contact/index.html.twig', ['validations' => $validations]);
    }


    private function validateContactPost(): array
    {
        $validations = ['inputs' => [], 'errors' => []];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validations['inputs'] = array_map('trim', $_POST);

            if (empty($validations['inputs']['firstname'])) {
                $validations['errors']['firstname'] = 'Le prénom est obligatoire';
            }

            if (empty($validations['inputs']['lastname'])) {
                $validations['errors']['lastname'] = 'Le nom est obligatoire';
            }

            if (empty($validations['inputs']['email'])) {
                $validations['errors']['email'] = 'L\'e-mail est obligatoire';
            } elseif (!filter_var($validations['inputs']['email'], FILTER_VALIDATE_EMAIL)) {
                $validations['errors']['email'] = 'L\'e-mail n\'a pas le bon format';
            }

            if (empty($validations['inputs']['object'])) {
                $validations['errors']['object'] = 'L\'objet est obligatoire';
            }

            if (empty($validations['inputs']['message'])) {
                $validations['errors']['message'] = 'Le message est obligatoire';
            }
        }
        return $validations;
    }
}
