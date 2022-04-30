<?php

namespace App\Controller;

class AnniversaryController extends AbstractController
{
    protected const NAME_LENGTH = 60;
    protected const PHONE_LENGTH = 10;

    public function index()
    {
        $errorsEmpty = null;
        $errorsFormat = null;
        $errors = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reservation = array_map('trim', $_POST);
            $errorsEmpty = $this->validate($reservation);
            $errorsFormat = $this->validateFormat($reservation);
            $errors = [...$errorsEmpty, ...$errorsFormat];
        }
      
        $rateManager = new RateManager();
        $anniversaryRates = $rateManager->selectAllAnniversaryRate();
        $detailsManager = new AnniversaryDetailsManager();
        $details = $detailsManager->selectAll('rate_id');
        return $this->twig->render('Anniversary/index.html.twig', [
            'anniversaryRates' => $anniversaryRates,
            'details' => $details,
            'errors' => $errors
        ]);
    }

    public function validate(array $reservation): array
    {

        $errorsEmpty = [];
        if (empty($reservation['firstname'])) {
            $errorsEmpty[] = 'Le prénom est obligatoire';
        }

        if (empty($reservation['lastname'])) {
            $errorsEmpty[] = 'Le nom est obligatoire';
        }

        if (empty($reservation['email'])) {
            $errorsEmpty[] = 'L\'e-mail est obligatoire';
        }
        if (empty($reservation['phone'])) {
            $errorsEmpty[] = 'Le numéro de téléphone est obligatoire';
        }

        if (empty($reservation['date'])) {
            $errorsEmpty[] = 'La date est obligatoire';
        }

        if (empty($reservation['message'])) {
            $errorsEmpty[] = 'Le message est obligatoire';
        }
        return $errorsEmpty;
    }
  
    public function validateFormat(array $reservation): array
    {
        $errorsFormat = [];
        if (strlen($reservation["firstname"]) > self::NAME_LENGTH) {
            $errorsFormat[] = "Le prénom doit faire moins de " . self::NAME_LENGTH . " caractères";
        }

        if (strlen($reservation["lastname"]) > self::NAME_LENGTH) {
            $errorsFormat[] = "Le nom doit faire moins de " . self::NAME_LENGTH . " caractères";
        }

        if (!filter_var($reservation['email'], FILTER_VALIDATE_EMAIL)) {
            $errorsFormat[] = "Mauvais format pour l'email " . $reservation["email"];
        }

        if (strlen($reservation["phone"]) > self::PHONE_LENGTH) {
            $errorsFormat[] = "Le numéro de téléphone ne doit pas dépasser " . self::PHONE_LENGTH . " caractères";
        }


        return $errorsFormat;
    }
}
