<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

// Récupération de l'action demandée
$action = Utils::request('action', 'home');

try {

    switch ($action) {

        // Page d'accueil
        case 'home':
            $bookController = new BookController($db);
            $bookController->showHome();
            break;

        // Liste des livres
        case 'books':
            $bookController = new BookController($db);
            $bookController->showBooks();
            break;

        // Détail d'un livre
        case 'book':
            $id = (int) Utils::request('id');

            $bookController = new BookController($db);
            $bookController->showBook($id);
            break;
            
        // Page de connexion
        case 'login':
            $view = new View('Connexion');
            $view->render('login');
            break;

        // Page inscription
        case 'register':
            $view = new View('Inscription');
            $view->render('register');
            break;

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {

    $view = new View('Erreur');

    $view->render('errorPage', [
        'errorMessage' => $e->getMessage()
    ]);
}