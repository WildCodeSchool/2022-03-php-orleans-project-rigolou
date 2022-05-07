<?php

namespace App\Controller;

use App\Model\AmusementManager;

class AdminAmusementController2 extends AbstractController
{
    public const AUTHORIZED_MIMES = ['image/jpeg','image/png', 'image/webp', 'image/gif'];
    public const MAX_FILE_SIZE = 1000000;

    public function index(string $success = '', string $name = ''): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $deletedName = '';
        if (trim($success) === 'deleted' && trim($name) !== '') {
            $deletedName = $name;
        }

        $editedName = '';
        if (trim($success) === 'edited' && trim($name) !== '') {
            $editedName = $name;
        }

        $amusementManager = new AmusementManager();
        $amusementItems = $amusementManager->selectAll('name');
        return $this->twig->render('Admin/Amusement/index.html.twig', [
            'amusementItems' => $amusementItems,
            'deletedName' => $deletedName,
            'editedName' => $editedName,
        ]);
    }

    public function add(): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $amusementItems = $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amusementItems = array_map('trim', $_POST);
            $errorsText = $this->textValidate($amusementItems);
            $errorsImage = $this->validateImage($_FILES['image']);

            $errors = [...$errorsText, ...$errorsImage];

            //if we do empty($errors) GrumPHP is not happy: Variable $errors in empty() always exists and is not falsy.
            if (empty($errorsText) && empty($errorsImage)) {
                $randomImageName = uniqid('', true) . '.'
                . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                move_uploaded_file($_FILES['image']['tmp_name'], APP_UPLOAD_PATH . $randomImageName);
                $amusementItems['image'] = $randomImageName;

                $amusementManager = new amusementManager();
                $amusementManager->insert($amusementItems);

                header('Location: /admin/attractions/');
            }
        }
        return $this->twig->render('Admin/Amusement/add.html.twig', [
            'errors' => $errors,
            'amusementItems' => $amusementItems,
            'authorizedMimes' => self::AUTHORIZED_MIMES,
            'maxFileSize' => self::MAX_FILE_SIZE / 1000000,
        ]);
    }

    public function edit(int $id): string
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            return '';
        }

        $amusementItems = $errors = [];
        $amusementManager = new AmusementManager();
        $amusementItems = $amusementManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($amusementItems)) {
            $savedImage = $amusementItems['image'];
            $amusementItems = array_map('trim', $_POST);
            $errorsText = $this->textValidate($amusementItems);
            $errorsImage = [];
            $isImageToBeChanged = false;
            if ($_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $isImageToBeChanged = true;
                $errorsImage = $this->validateImage($_FILES['image']);
            }

            $errors = [...$errorsText, ...$errorsImage];

            //if we do empty($errors) GrumPHP is not happy
            if (empty($errorsText) && empty($errorsImage)) {
                $amusementItems['id'] = $id;
                if ($isImageToBeChanged) {
                    $this->deleteImage($savedImage);
                    $randomImageName = uniqid('', true);
                    $randomImageName .= '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES['image']['tmp_name'], APP_UPLOAD_PATH . $randomImageName);
                    $amusementItems['image'] = $randomImageName;
                } else {
                    $amusementItems['image'] = $savedImage;
                }
                $amusementManager->update($amusementItems);
                header('Location: /admin/attractions?success=edited&name=' . $amusementItems['name']);
            }
        }

        return $this->twig->render('Admin/Amusement/edit.html.twig', [
            'errors' => $errors,
            'amusementItems' => $amusementItems,
            'authorizedMimes' => self::AUTHORIZED_MIMES,
            'maxFileSize' => self::MAX_FILE_SIZE / 1000000,
        ]);
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id'])) {
                $id = trim($_POST['id']);
                if (is_numeric($id) && $id > 0) {
                    $amusementManager = new AmusementManager();
                    $amusement = $amusementManager->selectOneById((int)$id);

                    if (!empty($amusement)) {
                        $this->deleteImage($amusement['image']);
                        $amusementManager->delete((int)$id);
                        header('Location: /admin/attractions?success=deleted&name=' . $amusement['name']);
                        return '';
                    }
                }
            }
        }

        header('Location: /admin/attractions/');
    }

    private function textValidate(array $amusementItems): array
    {
        $errors = [];
        if (empty($amusementItems['name'])) {
            $errors[] = 'Le nom est obligatoire';
        }

        $nameMaxLength = 100;
        if (strlen($amusementItems['name']) > $nameMaxLength) {
            $errors[] = 'Le nom ne doit pas dépasser ' . $nameMaxLength . ' caractères';
        }

        if (empty($amusementItems['description'])) {
            $errors[] = 'La description est obligatoire';
        }

        return $errors;
    }

    private function validateImage($file): array
    {
        $errors = [];
        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            $errors[] = 'L\'image est obligatoire';
        } elseif ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Problème de téléchargement du fichier';
        } else {
            if (!in_array(mime_content_type($file['tmp_name']), self::AUTHORIZED_MIMES)) {
                $errors[] = 'Le format de l\'image n\'est pas valide';
            }

            if (filesize($file['tmp_name']) > self::MAX_FILE_SIZE) {
                $errors[] = 'L\'image doit faire moins de ' . self::MAX_FILE_SIZE / 1000000 . 'mo';
            }
        }
        return $errors;
    }

    private function deleteImage(string $image)
    {
        if (is_file(APP_UPLOAD_PATH . $image)) {
            unlink(APP_UPLOAD_PATH . $image);
        }
    }
}
