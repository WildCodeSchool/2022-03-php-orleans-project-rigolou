<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)

return [
    '' => ['HomeController', 'index',],
    'anniversaire' => ['AnniversaryController', 'index'],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
    'attractions' => ['AmusementController', 'index',],
    'cafeteria' => ['CafeteriaController', 'index'],
    'evenements' => ['EventController', 'index'],
    'login' => ['LoginController', 'login'],
    'logout' => ['LoginController', 'logout'],
    'contact' => ['ContactController', 'index', ['send']],
    'admin/attractions' => ['AdminAmusementController', 'index'],
    'admin/cafeteria' => ['AdminCafeteriaController', 'index'],
    'admin/attractions/ajouter' => ['AdminAmusementController', 'add'],
    'admin/events' => ['AdminEventController', 'index'],
    'admin/anniversaire' => ['AdminAnniversaryDetailController', 'index'],
];
