<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Display contact page
     */
    public function index(): string
    {

        return $this->twig->render('Contact/index.html.twig');
    }

    private function validateContactPost(): array
    {
        $contactChecks = ['inputs' => [], 'errors' => []];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contactInputs = $contactChecks['inputs'] = array_map('trim', $_POST);

            if (empty($contactInputs['firstname'])) {
                $contactChecks['errors']['firstname'] = 'Le prénom est obligatoire';
            }

            if (empty($contactInputs['lastname'])) {
                $contactChecks['errors']['lastname'] = 'Le nom est obligatoire';
            }

            if (empty($contactInputs['email'])) {
                $contactChecks['errors']['email'] = 'L\'e-mail est obligatoire';
            } elseif (!filter_var($contactInputs['email'], FILTER_VALIDATE_EMAIL)) {
                $contactChecks['errors']['email'] = 'L\'e-mail n\'a pas le bon format';
            }

            if (empty($contactInputs['object'])) {
                $contactChecks['errors']['object'] = 'L\'objet est obligatoire';
            }

            if (empty($contactInputs['message'])) {
                $contactChecks['errors']['message'] = 'Le message est obligatoire';
            }
        }
        return $contactChecks;
    }

}
