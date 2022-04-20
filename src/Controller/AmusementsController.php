<?php

namespace App\Controller;

class AmusementsController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        return $this->twig->render('Amusements/index.html.twig');
    }
}
