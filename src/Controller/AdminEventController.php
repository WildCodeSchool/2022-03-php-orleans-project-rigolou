<?php

namespace App\Controller;

use App\Model\EventManager;

class AdminEventController extends AbstractController
{
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

    public function delete()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            if ($id > 0) {
                $eventManager = new EventManager();

                $this->deleteImage((int) $id);

                $eventManager->delete((int)$id);

                header('Location: /admin/events');
            }
        }
    }

    private function deleteImage(int $id)
    {
        $eventManager = new EventManager();
        $event = $eventManager->selectOneById((int) $id);
        if (!empty($event)) {
            $image = APP_UPLOAD_PATH . $event['image'];
            unlink($image);
        }
    }
}
