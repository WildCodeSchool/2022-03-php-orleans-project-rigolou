<?php

namespace App\Controller;

use App\Model\AnniversaryManager;
use App\Model\RateManager;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class AdminAnniversaryController extends AbstractController
{
    public function index(): string
    {

        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $anniversaryManager = new AnniversaryManager();
        $reservations = $anniversaryManager->selectAll('reservation_date', 'DESC');

        return $this->twig->render('Admin/Anniversary/index.html.twig', ['reservations' => $reservations]);
    }

    public function details(int $id): string
    {

        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $reservationManager = new AnniversaryManager();
        $reservation = $reservationManager->selectOneById($id);
        $rateManager = new RateManager();
        $anniversaryRates = $rateManager->selectOneById($reservation['rate_id']);
        $titre = $anniversaryRates['description'];
        return $this->twig->render('Admin/Anniversary/details.html.twig', [
            'reservation' => $reservation,
            'titre' => $titre,
        ]);
    }

    public function confirm()
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reservation = array_map('trim', $_POST);
            if ($reservation['bool']) {
                $anniversaryManager = new AnniversaryManager();
                $mailContent = $anniversaryManager->selectOneById((int)$reservation['id']);
                $this->sendMail($mailContent);
            }
            $comfirmManager = new AnniversaryManager();
            $comfirmManager->confirm($reservation['bool'], $reservation['id']);
            header('Location: /admin/reservations');
            return '';
        }
    }

    private function sendMail(array $mailContent): void
    {
        $message = $this->twig->render('/Admin/Anniversary/mail.html.twig', ['mailContent' => $mailContent]);

        $mail = (new Email())
         ->from(MAIL_INBOX)
         ->to($mailContent['email'])
         ->subject('Confirmation réservation')
         ->html($message)
        ;

        $transport = Transport::fromDsn(MAILER_DSN);
        $mailer = new Mailer($transport);
        $mailer->send($mail);
    }

    public function delete()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $reservationManager = new AnniversaryManager();
            $reservation = $reservationManager->selectOneById((int) $id);

            if (!empty($reservation)) {
                $reservationManager->delete((int)$id);

                header('Location: /admin/reservations');
            }
        }
    }
}
