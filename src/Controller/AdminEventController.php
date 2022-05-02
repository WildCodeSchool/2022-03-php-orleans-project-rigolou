<?php

namespace App\Controller;

use App\Model\EventManager;

class AdminEventController extends AbstractController
{
    public function index(): string
    {
        $eventManager = new EventManager();
        $eventItems = $eventManager->selectAll('title');

        return $this->twig->render('Admin/Events/index.html.twig', ['eventItems' => $eventItems]);
    }
}
