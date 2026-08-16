<?php

class HomeController
{
    private BookManager $bookManager;

    public function __construct(PDO $db)
    {
        $this->bookManager = new BookManager($db);
    }

    public function index(): void
    {
        $books = $this->bookManager->getLatestBooks();

        require 'views/home.php';
    }
}