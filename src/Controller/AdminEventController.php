<?php

namespace App\Controller;

use App\Model\EventManager;

class AdminEventController extends AbstractController
{
    public const MAX_TITLE_SIZE = 100;

    public function index(): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $eventManager = new EventManager();
        $eventItems = $eventManager->selectAll('title');

        return $this->twig->render('Admin/Events/index.html.twig', ['eventItems' => $eventItems]);
    }


    public function add(): ?string
    {
        $errors = [];
        $event = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $event = array_map('trim', $_POST);
            $errorsText = $this->textValidate($event);
            $errorsImage = [];
            if (file_exists($_FILES['image']['tmp_name'])) {
                $errorsImage = $this->validateImage();
            } else {
                $errorsImage[] = 'L\'image est obligatoire';
            }

            $errors = [...$errorsText, ...$errorsImage];


            if (empty($errorsText) && empty($errorsImage)) {
                $randomImageName = uniqid('', true) . '.'
                    . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                move_uploaded_file($_FILES['image']['tmp_name'], APP_UPLOAD_PATH . $randomImageName);
                $event['image'] = $randomImageName;

                $eventManager = new EventManager();
                $eventManager->insert($event);
                header('Location: /admin/events/');
            }
        }

        return $this->twig->render('Admin/Events/add.html.twig', [
            'errors' => $errors,
            'event' => $event,
            'authorizedMimes' => AdminAmusementController::AUTHORIZED_MIMES,
            'maxFileSize' => AdminAmusementController::MAX_FILE_SIZE / 1000000,
        ]);
    }

    private function validateImage(): array
    {
        $errors = [];
        if (!in_array(mime_content_type($_FILES['image']['tmp_name']), AdminAmusementController::AUTHORIZED_MIMES)) {
            $errors[] = 'Le format de l\'image n\'est pas valide';
        }

        if (filesize($_FILES['image']['tmp_name']) > AdminAmusementController::MAX_FILE_SIZE) {
            $errors[] = 'L\'image doit faire moins de ' . AdminAmusementController::MAX_FILE_SIZE / 1000000 . 'mo';
        }
        return $errors;
    }

    private function textValidate(array $event): array
    {
        $errors = [];

        if (empty($event['title'])) {
            $errors[] = 'Vous devez ajouter un titre !';
        }
        if (empty($event['date'])) {
            $errors[] = 'Vous devez ajouter une date !';
        }
        if (empty($event['description'])) {
            $errors[] = 'Vous devez ajouter une description !';
        }
        if (strlen($event['title']) > self::MAX_TITLE_SIZE) {
            $errors[] = 'Votre titre doit faire moins de ' . self::MAX_TITLE_SIZE;
        }

        return $errors;
    }
}
