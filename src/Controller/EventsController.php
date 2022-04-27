<?php

namespace App\Controller;

use App\Model\EventsManager;

class EventsController extends AbstractController
{
    public function index(): string
    {
        


        $eventsManager = new EventsManager();
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
