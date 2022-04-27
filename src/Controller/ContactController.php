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

        $validations = $this->validateContactPost();

        if (isset($validations['errors']) && empty($validations['errors'])) {
            $this->sendMail($validations['inputs']);
            header('Location: /contact?send=success');
        }

        return $this->twig->render('Contact/index.html.twig', [
            'validations' => $validations,
            'messageSend' => $messageSend
        ]);
    }


    private function validateContactPost(): array
    {
        $validations = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validations['errors'] = [];
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

            if (empty($validations['inputs']['subject'])) {
                $validations['errors']['subject'] = 'L\'objet est obligatoire';
            }

            if (empty($validations['inputs']['message'])) {
                $validations['errors']['message'] = 'Le message est obligatoire';
            }
        }
        return $validations;
    }

    private function sendMail(array $inputs): void
    {
        $message = '<p>Message de:<br>'
        . $inputs['firstname'] . ' ' . $inputs['lastname'] . '<br>';
        if ($inputs['phone'] !== '') {
            $message .= 'Tel: ' . $inputs['phone'] . '<br>';
        }
        $message .= 'Email: ' . $inputs['email'];
        $message .= '<p>'  . $inputs['message'] . '</p>';

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
