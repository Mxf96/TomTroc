<?php

class BookController
{
    private BookManager $bookManager;

    public function __construct(PDO $db)
    {
        $this->bookManager = new BookManager($db);
    }

    /**
     * Affiche la page d'accueil.
     */
    public function showHome(): void
    {
        $books = $this->bookManager->getLatestBooks();

        $view = new View('Accueil');
        $view->render('home', [
            'books' => $books
        ]);
    }

    /**
     * Affiche la liste de tous les livres.
     */
    public function showBooks(): void
    {
        $books = $this->bookManager->getAllBooks();

        $view = new View('Livres');
        $view->render('books', [
            'books' => $books
        ]);
    }

    /**
     * Affiche le détail d'un livre.
     */
    public function showBook(int $id): void
    {
        $book = $this->bookManager->getBookById($id);

        if ($book === false) {
            throw new Exception("Le livre demandé n'existe pas.");
        }

        $view = new View($book['title']);
        $view->render('bookDetails', [
            'book' => $book
        ]);
    }
    /**
     * Affiche et traite le formulaire de modification d'un livre.
     */
    public function editBook(int $id): void
    {
        // L'utilisateur doit être connecté.
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $idUser = (int) $_SESSION['user']['id_user'];

        $book = $this->bookManager->getBookById($id);

        if ($book === false) {
            throw new Exception("Le livre demandé n'existe pas.");
        }

        // Vérifie que le livre appartient à l'utilisateur connecté.
        if ((int) $book['id_user'] !== $idUser) {
            throw new Exception(
                "Vous n'êtes pas autorisé à modifier ce livre."
            );
        }


        // ===========================
        // AFFICHAGE DU FORMULAIRE
        // ===========================

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            $view = new View('Modifier un livre');

            $view->render('editBook', [
                'book' => $book
            ]);

            return;
        }


        // ===========================
        // RÉCUPÉRATION
        // ===========================

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'available';


        // ===========================
        // VALIDATION
        // ===========================

        if (
            empty($title)
            || empty($author)
            || empty($description)
        ) {
            $view = new View('Modifier un livre');

            $view->render('editBook', [
                'book' => $book,
                'errorMessage' => 'Tous les champs sont obligatoires.'
            ]);

            return;
        }

        $allowedStatuses = [
            'available',
            'unavailable'
        ];

        if (!in_array($status, $allowedStatuses, true)) {
            throw new Exception("Statut du livre invalide.");
        }

        // ===========================
        // MODIFICATION
        // ===========================

        $this->bookManager->updateBook(
            $id,
            $idUser,
            $title,
            $author,
            $description,
            $status
        );

        header('Location: index.php?action=account');
        exit;
    }

    /**
     * Supprime un livre appartenant à l'utilisateur connecté.
     */
    public function deleteBook(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }


        // La suppression doit obligatoirement être envoyée en POST.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception(
                "Méthode non autorisée pour supprimer un livre."
            );
        }

        $idBook = (int) ($_POST['id'] ?? 0);
        $idUser = (int) $_SESSION['user']['id_user'];

        if ($idBook <= 0) {
            throw new Exception("Identifiant du livre invalide.");
        }

        $book = $this->bookManager->getBookById($idBook);


        if ($book === false) {
            throw new Exception("Le livre demandé n'existe pas.");
        }

        if ((int) $book['id_user'] !== $idUser) {
            throw new Exception(
                "Vous n'êtes pas autorisé à supprimer ce livre."
            );
        }

        $this->bookManager->deleteBook(
            $idBook,
            $idUser
        );

        header('Location: index.php?action=account');
        exit;
    }
}