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
    'admin/cafeteria' => ['AdminCafeteriaController', 'index'],
    'admin/attractions' => ['AdminAmusementController', 'index', ['success', 'name']],
    'admin/attractions/ajouter' => ['AdminAmusementController', 'add'],
    'admin/attractions/modifier' => ['AdminAmusementController', 'edit', ['id']],
    'admin/attractions/supprimer' => ['AdminAmusementController', 'delete'],
    'admin/events' => ['AdminEventController', 'index'],
    'admin/anniversaire' => ['AdminAnniversaryDetailController', 'index'],
    'admin/cafeteria/ajouter' => ['AdminCafeteriaController', 'add'],
    'admin/events/ajouter' => ['AdminEventController', 'add'],
    'admin/events/supprimer' => ['AdminEventController', 'delete'],
    'admin/events/modifier' => ['AdminEventController', 'edit', ['id']],
    'admin/tarifs' => ['AdminRateController', 'index', ['msg']],
    'admin/tarifs/ajouter' => ['AdminRateController', 'add'],
    'admin/tarifs/modifier' => ['AdminRateController', 'edit', ['id']],
    'admin' => ['AdminController', 'index'],
    'admin/cafeteria/supprimer' => ['AdminCafeteriaController', 'delete'],
];
