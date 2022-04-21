<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;


    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => (ENV === 'dev'),
            ]
        );
        $this->twig->addExtension(new DebugExtension());
    }

    protected function checkContactPost(): array
    {
        $contactChecks = ['buttonClicked' => false, 'inputs' => [], 'errors' => []];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['contactForm'] === '1') {
            $contactChecks['buttonClicked'] = true;
            $contactInputs = $contactChecks['inputs'][] = array_map('trim', $_POST);

            if (empty($contactInputs['firstname'])) {
                $contactChecks['errors']['firstname'] = 'Le prénom est obligatoire';
            }

            if (empty($contactInputs['lastname'])) {
                $contactChecks['errors']['lastname'] = 'Le nom est obligatoire';
            }

            if (empty($contactInputs['email'])) {
                $contactChecks['errors']['email'] = 'L\'e-mail est obligatoire';
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
