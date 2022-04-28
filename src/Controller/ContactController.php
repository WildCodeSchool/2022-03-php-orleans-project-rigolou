<?php

namespace App\Controller;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    /**
     * Display contact page
     */
    public function index(string $send = ''): string
    {
        $messageSend = false;
        if ($send !== '' && trim($send) === 'success') {
            $messageSend = true;
        }

        $errors = [];
        $inputs = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputs = array_map('trim', $_POST);
            $errors = $this->validateContactPost($inputs);
            if (empty($errors)) {
                $this->sendMail($inputs);
                header('Location: /contact?send=success');
            }
        }

        return $this->twig->render('Contact/index.html.twig', [
            'errors' => $errors,
            'inputs' => $inputs,
            'messageSend' => $messageSend,
        ]);
    }


    private function validateContactPost(array $inputs): array
    {
        $errors = [];
        if (empty($inputs['firstname'])) {
            $errors['firstname'] = 'Le prénom est obligatoire';
        }

        if (empty($inputs['lastname'])) {
            $errors['lastname'] = 'Le nom est obligatoire';
        }

        if (empty($inputs['email'])) {
            $errors['email'] = 'L\'e-mail est obligatoire';
        } elseif (!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'L\'e-mail n\'a pas le bon format';
        }

        if (empty($inputs['subject'])) {
            $errors['subject'] = 'L\'objet est obligatoire';
        }

        if (empty($inputs['message'])) {
            $errors['message'] = 'Le message est obligatoire';
        }
        return $errors;
    }

    private function sendMail(array $inputs): void
    {
        $message = $this->twig->render('Contact/mail.html.twig', ['inputs' => $inputs]);

        $mail = (new Email())
         ->from($inputs['email'])
         ->to(MAIL_INBOX)
         ->subject($inputs['subject'])
         ->html($message)
        ;

        $transport = Transport::fromDsn(MAILER_DSN);
        $mailer = new Mailer($transport);
        $mailer->send($mail);
    }
}
