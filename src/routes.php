<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)

return [
    '' => ['HomeController', 'index',],
    'anniversaire' => ['AnniversaryController', 'index', ['message']],
    'attractions' => ['AmusementController', 'index',],
    'cafeteria' => ['CafeteriaController', 'index'],
    'evenements' => ['EventController', 'index'],
    'login' => ['LoginController', 'login'],
    'logout' => ['LoginController', 'logout'],
    'contact' => ['ContactController', 'index', ['send']],
    'admin/reservations' => ['AdminAnniversaryController', 'index'],
    'admin/reservations/details' => ['AdminAnniversaryController', 'details', ['id']],
    'admin/reservations/valider' => ['AdminAnniversaryController', 'confirm'],
    'admin/reservations/supprimer' => ['AdminAnniversaryController', 'delete'],
    'admin/cafeteria' => ['AdminCafeteriaController', 'index'],
    'admin/attractions' => ['AdminAmusementController', 'index', ['success', 'name']],
    'admin/attractions/ajouter' => ['AdminAmusementController', 'add'],
    'admin/attractions/modifier' => ['AdminAmusementController', 'edit', ['id']],
    'admin/attractions/supprimer' => ['AdminAmusementController', 'delete'],
    'admin/events' => ['AdminEventController', 'index', ['status', 'event']],
    'admin/anniversaire' => ['AdminAnniversaryDetailController', 'index', ['message']],
    'admin/anniversaire/ajouter' => ['AdminAnniversaryDetailController', 'add', ['rate']],
    'admin/anniversaire/modifier' => ['AdminAnniversaryDetailController', 'edit', ['rate', 'id']],
    'admin/anniversaire/supprimer' => ['AdminAnniversaryDetailController', 'delete'],
    'admin/cafeteria/ajouter' => ['AdminCafeteriaController', 'add'],
    'admin/events/ajouter' => ['AdminEventController', 'add'],
    'admin/events/supprimer' => ['AdminEventController', 'delete'],
    'admin/events/modifier' => ['AdminEventController', 'edit', ['id']],
    'admin/tarifs' => ['AdminRateController', 'index', ['msg']],
    'admin/tarifs/ajouter' => ['AdminRateController', 'add'],
    'admin/tarifs/modifier' => ['AdminRateController', 'edit', ['id']],
    'admin/tarifs/supprimer' => ['AdminRateController', 'delete'],
    'admin' => ['AdminController', 'index'],
    'admin/cafeteria/modifier' => ['AdminCafeteriaController', 'edit', ['id']],
    'admin/cafeteria/supprimer' => ['AdminCafeteriaController', 'delete'],
];
