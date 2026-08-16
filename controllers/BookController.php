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
        $view->render('book', [
            'book' => $book
        ]);
    }
}