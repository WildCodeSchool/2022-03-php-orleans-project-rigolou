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
        $contact = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contact = array_map('trim', $_POST);
            $errors = $this->validateContactPost($contact);
            if (empty($errors)) {
                $this->sendMail($contact);
                header('Location: /contact?send=success');
            }
        }

        return $this->twig->render('Contact/index.html.twig', [
            'errors' => $errors,
            'contact' => $contact,
            'messageSend' => $messageSend,
        ]);
    }


    private function validateContactPost(array $contact): array
    {
        $errors = [];
        if (empty($contact['firstname'])) {
            $errors['firstname'] = 'Le prénom est obligatoire';
        }

        if (empty($contact['lastname'])) {
            $errors['lastname'] = 'Le nom est obligatoire';
        }

        if (empty($contact['email'])) {
            $errors['email'] = 'L\'e-mail est obligatoire';
        } elseif (!filter_var($contact['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'L\'e-mail n\'a pas le bon format';
        }

        if (empty($contact['subject'])) {
            $errors['subject'] = 'L\'objet est obligatoire';
        }

        if (empty($contact['message'])) {
            $errors['message'] = 'Le message est obligatoire';
        }
        return $errors;
    }

    private function sendMail(array $contact): void
    {
        $message = $this->twig->render('Contact/mail.html.twig', ['contact' => $contact]);

        $mail = (new Email())
         ->from($contact['email'])
         ->to(MAIL_INBOX)
         ->subject($contact['subject'])
         ->html($message)
        ;

        $transport = Transport::fromDsn(MAILER_DSN);
        $mailer = new Mailer($transport);
        $mailer->send($mail);
    }
}
