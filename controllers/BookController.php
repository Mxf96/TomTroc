<?php

/**
 * Classe qui gère les articles.
 */

class BookController
{
    public function showHome(): void
    {
        $view = new View('Accueil');
        $view->render('home');
    }
}