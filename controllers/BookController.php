<?php

class BookController
{
    private BookManager $bookManager;
    private UploadService $uploadService;

    public function __construct(PDO $db)
    {
        $this->bookManager = new BookManager($db);
        $this->uploadService = new UploadService();
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
        $search = trim(
            Utils::request('search', '')
        );

        if ($search !== '') {
            $books = $this->bookManager->searchBooks($search);
        } else {
            $books = $this->bookManager->getAllBooks();
        }

        $view = new View('Nos livres');

        $view->render('books', [
            'books' => $books,
            'search' => $search
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
     * Affiche et traite le formulaire d'ajout d'un livre.
     */
    public function addBook(): void
    {
        // ===========================
        // UTILISATEUR CONNECTÉ
        // ===========================

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $idUser = (int) $_SESSION['user']['id_user'];

        // ===========================
        // AFFICHAGE DU FORMULAIRE
        // ===========================

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            $view = new View('Ajouter un livre');
            $view->render('addBook');

            return;
        }

        // ===========================
        // RÉCUPÉRATION DES DONNÉES
        // ===========================

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'available';

        // ===========================
        // VALIDATION
        // ===========================

        // Titre
        if ($title === '') {

            $view = new View('Ajouter un livre');

            $view->render('addBook', [
                'errorMessage' => 'Veuillez renseigner le titre du livre.'
            ]);

            return;
        }


        // Auteur
        if ($author === '') {

            $view = new View('Ajouter un livre');

            $view->render('addBook', [
                'errorMessage' => "Veuillez renseigner l'auteur du livre."
            ]);

            return;
        }


        // Description
        if ($description === '') {

            $view = new View('Ajouter un livre');

            $view->render('addBook', [
                'errorMessage' => 'Veuillez renseigner une description du livre.'
            ]);

            return;
        }


        // Statut
        $allowedStatuses = [
            'available',
            'unavailable'
        ];

        if (!in_array($status, $allowedStatuses, true)) {

            $view = new View('Ajouter un livre');

            $view->render('addBook', [
                'errorMessage' => 'La disponibilité sélectionnée est invalide.'
            ]);

            return;
        }


        // Image
        if (
            !isset($_FILES['image'])
            || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE
        ) {

            $view = new View('Ajouter un livre');

            $view->render('addBook', [
                'errorMessage' => 'Veuillez sélectionner une photo du livre.'
            ]);

            return;
        }


        // Autre erreur pendant l'upload
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {

            $view = new View('Ajouter un livre');

            $view->render('addBook', [
                'errorMessage' => "Une erreur est survenue lors de l'envoi de l'image."
            ]);

            return;
        }

        try {

            $image = $this->uploadService->uploadBookImage(
                $_FILES['image']
            );
        } catch (Exception $e) {

            $view = new View('Ajouter un livre');

            $view->render('addBook', [
                'errorMessage' => $e->getMessage()
            ]);

            return;
        }

        // ===========================
        // AJOUT EN BASE DE DONNÉES
        // ===========================

        $this->bookManager->createBook(
            $title,
            $author,
            $image,
            $description,
            $status,
            $idUser
        );

        // ===========================
        // REDIRECTION
        // ===========================

        header('Location: index.php?action=account');
        exit;
    }

    /**
     * Affiche et traite le formulaire de modification d'un livre.
     */
    public function editBook(int $id): void
    {
        // ===========================
        // UTILISATEUR CONNECTÉ
        // ===========================

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $idUser = (int) $_SESSION['user']['id_user'];

        // ===========================
        // RÉCUPÉRATION DU LIVRE
        // ===========================

        $book = $this->bookManager->getBookById($id);

        if ($book === false) {
            throw new Exception(
                "Le livre demandé n'existe pas."
            );
        }

        // Vérifie que le livre appartient
        // à l'utilisateur connecté.
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
        // RÉCUPÉRATION DES DONNÉES
        // ===========================

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'available';

        // ===========================
        // VALIDATION DU TITRE
        // ===========================

        if ($title === '') {

            $view = new View('Modifier un livre');

            $view->render('editBook', [
                'book' => $book,
                'errorMessage' => 'Veuillez renseigner le titre du livre.'
            ]);

            return;
        }

        // ===========================
        // VALIDATION DE L'AUTEUR
        // ===========================

        if ($author === '') {

            $view = new View('Modifier un livre');

            $view->render('editBook', [
                'book' => $book,
                'errorMessage' => "Veuillez renseigner l'auteur du livre."
            ]);

            return;
        }

        // ===========================
        // VALIDATION DESCRIPTION
        // ===========================

        if ($description === '') {

            $view = new View('Modifier un livre');

            $view->render('editBook', [
                'book' => $book,
                'errorMessage' => 'Veuillez renseigner une description du livre.'
            ]);

            return;
        }

        // ===========================
        // VALIDATION STATUT
        // ===========================

        $allowedStatuses = [
            'available',
            'unavailable'
        ];

        if (!in_array($status, $allowedStatuses, true)) {

            $view = new View('Modifier un livre');

            $view->render('editBook', [
                'book' => $book,
                'errorMessage' => 'La disponibilité sélectionnée est invalide.'
            ]);

            return;
        }

        // ===========================
        // GESTION DE L'IMAGE
        // ===========================

        // Par défaut, conserve l'image actuelle.
        $image = $book['image'];

        // Une nouvelle image a été sélectionnée.
        if (
            isset($_FILES['image'])
            && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
        ) {

            // Erreur pendant l'envoi.
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {

                $view = new View('Modifier un livre');

                $view->render('editBook', [
                    'book' => $book,
                    'errorMessage' => "Une erreur est survenue lors de l'envoi de l'image."
                ]);

                return;
            }

            try {

                $image = $this->uploadService->uploadBookImage(
                    $_FILES['image']
                );
            } catch (Exception $e) {

                $view = new View('Modifier un livre');

                $view->render('editBook', [
                    'book' => $book,
                    'errorMessage' => $e->getMessage()
                ]);

                return;
            }
        }

        // ===========================
        // MODIFICATION
        // ===========================

        $this->bookManager->updateBook(
            $id,
            $idUser,
            $title,
            $author,
            $image,
            $description,
            $status
        );

        // ===========================
        // REDIRECTION
        // ===========================

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