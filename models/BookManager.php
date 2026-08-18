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
            u.username,
            u.avatar
        FROM Books b
        INNER JOIN Users u ON b.id_user = u.id_user
        WHERE b.id_book = :id
    ";

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur grâce à son identifiant.
     */
    public function getUserById(int $id): array|false
    {
        $sql = "
        SELECT
            id_user,
            username,
            email,
            firstname,
            lastname,
            phone,
            description,
            avatar,
            created_at,
            updated_at
        FROM Users
        WHERE id_user = :id
        LIMIT 1
    ";

        $statement = $this->db->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les livres appartenant à un utilisateur.
     */
    public function getBooksByUserId(int $idUser): array
    {
        $sql = "
        SELECT
            id_book,
            title,
            author,
            image,
            description,
            status,
            created_at,
            updated_at,
            id_user
        FROM Books
        WHERE id_user = :id_user
        ORDER BY created_at DESC
    ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(
            ':id_user',
            $idUser,
            PDO::PARAM_INT
        );

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Modifie un livre appartenant à un utilisateur.
     */
    public function updateBook(
        int $idBook,
        int $idUser,
        string $title,
        string $author,
        string $description,
        string $status
    ): bool {

        $sql = "
        UPDATE Books
        SET
            title = :title,
            author = :author,
            description = :description,
            status = :status,
            updated_at = NOW()
        WHERE id_book = :id_book
        AND id_user = :id_user
    ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':title', $title, PDO::PARAM_STR);
        $statement->bindValue(':author', $author, PDO::PARAM_STR);
        $statement->bindValue(':description', $description, PDO::PARAM_STR);
        $statement->bindValue(':status', $status, PDO::PARAM_STR);

        $statement->bindValue(':id_book', $idBook, PDO::PARAM_INT);
        $statement->bindValue(':id_user', $idUser, PDO::PARAM_INT);

        return $statement->execute();
    }

    /**
     * Supprime un livre appartenant à un utilisateur.
     */
    public function deleteBook(int $idBook, int $idUser): bool
    {
        $sql = "
        DELETE FROM Books
        WHERE id_book = :id_book
        AND id_user = :id_user
    ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':id_book', $idBook, PDO::PARAM_INT);
        $statement->bindValue(':id_user', $idUser, PDO::PARAM_INT);

        return $statement->execute();
    }
}