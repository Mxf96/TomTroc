<?php

require_once 'config/config.php';
require_once 'config/autoload.php';

// Récupération de l'action demandée
$action = Utils::request('action', 'home');

try {

    // Nombre de messages non lus de l'utilisateur connecté
    if (isset($_SESSION['user']['id_user'])) {

        $unreadMessageManager = new MessageManager($db);

        $_SESSION['unread_message_count'] =
            $unreadMessageManager->getUnreadCountByUser(
                (int) $_SESSION['user']['id_user']
            );
    } else {

        unset($_SESSION['unread_message_count']);
    }

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
            $userController = new UserController($db);
            $userController->login();
            break;

        // Page inscription
        case 'register':
            $userController = new UserController($db);
            $userController->register();
            break;

        // Déconnexion
        case 'logout':
            $userController = new UserController($db);
            $userController->logout();
            break;

        // Mon compte
        case 'account':
            $userController = new UserController($db);
            $userController->account();
            break;

        // Ajout d'un livre
        case 'addBook':
            $bookController = new BookController($db);
            $bookController->addBook();
            break;

        // Modification d'un livre
        case 'editBook':
            $id = (int) Utils::request('id');

            $bookController = new BookController($db);
            $bookController->editBook($id);
            break;

        // Suppression d'un livre
        case 'deleteBook':
            $bookController = new BookController($db);
            $bookController->deleteBook();
            break;

        // Profil public d'un utilisateur
        case 'profile':
            $id = (int) Utils::request('id');

            $userController = new UserController($db);
            $userController->profile($id);
            break;

        // Messagerie
        case 'messages':
            $messageController = new MessageController($db);
            $messageController->showMessages();
            break;

        // Envoi d'un message
        case 'sendMessage':
            $messageController = new MessageController($db);
            $messageController->sendMessage();
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