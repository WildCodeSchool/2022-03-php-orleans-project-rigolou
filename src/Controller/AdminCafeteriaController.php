<?php

namespace App\Controller;

use App\Model\CafeteriaManager;

class AdminCafeteriaController extends AbstractController
{
    public function index(): string
    {
        $cafeteriatManager = new CafeteriaManager();
        $cafeteriaItems = $cafeteriatManager->selectAll('name');

        return $this->twig->render('Admin/Cafeteria/index.html.twig', ['cafeteriaItems' => $cafeteriaItems]);
    }

    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $cafeteria = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $cafeteriaManager = new CafeteriaManager();
            $id = $cafeteriaManager->insert($cafeteria);

            header('Location:/cafeteria/show?id=' . $id);
            return null;
        }

        return $this->twig->render('Admin/Cafeteria/add.html.twig');
    }
}
