<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

// Récupération de l'action demandée
$action = Utils::request('action', 'home');

try {

    switch ($action) {

        // Pages publiques
        case 'home':
            $bookController = new BookController();
            $bookController->showHome();
            break;

        // case 'books':
        //     $bookController = new BookController();
        //     $bookController->showBooks();
        //     break;

        // case 'account':
        //     $userController = new UserController();
        //     $userController->showAccount();
        //     break;

        // case 'login':
        //     $userController = new UserController();
        //     $userController->showLogin();
        //     break;

        // case 'register':
        //     $userController = new UserController();
        //     $userController->showRegister();
        //     break;

        // case 'messages':
        //     $messageController = new MessageController();
        //     $messageController->showMessages();
        //     break;

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {

    $view = new View('Erreur');
    $view->render('errorPage', [
        'errorMessage' => $e->getMessage()
    ]);
}