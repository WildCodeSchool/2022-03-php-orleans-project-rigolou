<?php

namespace App\Controller;

class AmusementController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('Amusements/index.html.twig');
    }
}
