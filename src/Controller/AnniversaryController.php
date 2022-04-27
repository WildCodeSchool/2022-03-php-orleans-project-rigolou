<?php

namespace App\Controller;

class AnniversaryController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        return $this->twig->render('Anniversary/index.html.twig');
    }
}
