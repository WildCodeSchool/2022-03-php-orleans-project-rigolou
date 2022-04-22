<?php

namespace App\Controller;

class CafeteriaController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Cafeteria/index.html.twig');
    }
}
