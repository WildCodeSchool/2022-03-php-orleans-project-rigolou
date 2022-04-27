<?php

namespace App\Controller;

class AnniversaryController extends AbstractController
{
    public function index()
    {
        return $this->twig->render('Anniversary/index.html.twig');
    }
}