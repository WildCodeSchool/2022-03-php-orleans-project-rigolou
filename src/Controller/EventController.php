<?php

namespace App\Controller;

use App\Model\EventManager;

class EventController extends AbstractController
{
    public function index(): string
    {
        $eventsManager = new EventManager();
        $pastEvents = $eventsManager->selectAllPastEvents();
        $upcomingEvents = $eventsManager->selectAllUpcomingEvents();
        return $this->twig->render(
            'Events/index.html.twig',
            [
                'upcomingEvents' => $upcomingEvents,
                'pastEvents' => $pastEvents,
            ]
        );
    }
}
