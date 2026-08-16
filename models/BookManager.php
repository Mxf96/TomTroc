<?php

class BookManager
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Récupère les derniers livres ajoutés.
     *
     * @return array
     */
    public function getLatestBooks(): array
    {
        $sql = "
            SELECT 
                b.id_book,
                b.title,
                b.author,
                b.image,
                b.description,
                b.status,
                b.created_at,
                b.updated_at,
                b.id_user,
                u.username
            FROM Books b
            INNER JOIN Users u ON b.id_user = u.id_user
            ORDER BY b.created_at DESC
            LIMIT 4
        ";

        $statement = $this->db->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les livres.
     *
     * @return array
     */
    public function getAllBooks(): array
    {
        $sql = "
        SELECT 
            b.id_book,
            b.title,
            b.author,
            b.image,
            b.description,
            b.status,
            b.created_at,
            b.updated_at,
            b.id_user,
            u.username
        FROM Books b
        INNER JOIN Users u ON b.id_user = u.id_user
        ORDER BY b.created_at DESC
    ";

        $statement = $this->db->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un livre grâce à son identifiant.
     *
     * @param int $id
     * @return array|false
     */
    public function getBookById(int $id): array|false
    {
        $sql = "
        SELECT 
            b.id_book,
            b.title,
            b.author,
            b.image,
            b.description,
            b.status,
            b.created_at,
            b.updated_at,
            b.id_user,
            u.username
        FROM Books b
        INNER JOIN Users u ON b.id_user = u.id_user
        WHERE b.id_book = :id
    ";

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}