<?php

class UserManager
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Vérifie si un pseudo existe déjà.
     */
    public function usernameExists(string $username): bool
    {
        $sql = "
            SELECT id_user
            FROM Users
            WHERE username = :username
            LIMIT 1
        ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':username', $username);

        $statement->execute();

        return $statement->fetch() !== false;
    }

    /**
     * Vérifie si une adresse email existe déjà.
     */
    public function emailExists(string $email): bool
    {
        $sql = "
            SELECT id_user
            FROM Users
            WHERE email = :email
            LIMIT 1
        ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':email', $email);

        $statement->execute();

        return $statement->fetch() !== false;
    }

    /**
     * Ajoute un nouvel utilisateur dans la base de données.
     */
    public function createUser(
        string $username,
        string $email,
        string $password
    ): bool {

        $sql = "
            INSERT INTO Users (
                username,
                email,
                password,
                avatar,
                created_at,
                updated_at
            )
            VALUES (
                :username,
                :email,
                :password,
                :avatar,
                NOW(),
                NOW()
            )
        ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->bindValue(
            ':avatar',
            './assets/img/pictures/default.png'
        );

        return $statement->execute();
    }

    /**
     * Récupère un utilisateur grâce à son adresse email.
     *
     * @param string $email
     * @return array|false
     */
    public function getUserByEmail(string $email): array|false
    {
        $sql = "
        SELECT
            id_user,
            username,
            email,
            password,
            firstname,
            lastname,
            phone,
            description,
            avatar,
            created_at,
            updated_at
        FROM Users
        WHERE email = :email
        LIMIT 1
    ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(
            ':email',
            $email,
            PDO::PARAM_STR
        );

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}