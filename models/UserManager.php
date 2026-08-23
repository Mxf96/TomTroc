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
     * Vérifie si un pseudo est déjà utilisé par un autre utilisateur.
     */
    public function usernameExistsForOtherUser(string $username, int $idUser): bool
    {
        $sql = "
        SELECT id_user
        FROM Users
        WHERE username = :username
        AND id_user != :id_user
        LIMIT 1
    ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->bindValue(':id_user', $idUser, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch() !== false;
    }

    /**
     * Vérifie si un email est déjà utilisé par un autre utilisateur.
     */
    public function emailExistsForOtherUser(string $email, int $idUser): bool
    {
        $sql = "
        SELECT id_user
        FROM Users
        WHERE email = :email
        AND id_user != :id_user
        LIMIT 1
    ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':id_user', $idUser, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch() !== false;
    }

    /**
     * Modifie les informations personnelles d'un utilisateur.
     */
    public function updateUser(
        int $idUser,
        string $username,
        string $email,
        ?string $password = null
    ): bool {

        // Si un nouveau mot de passe a été renseigné.
        if ($password !== null) {

            $sql = "
            UPDATE Users
            SET
                username = :username,
                email = :email,
                password = :password,
                updated_at = NOW()
            WHERE id_user = :id_user
        ";

            $statement = $this->db->prepare($sql);

            $statement->bindValue(':password', $password, PDO::PARAM_STR);
        } else {

            // Sinon, on ne modifie pas le mot de passe.
            $sql = "
            UPDATE Users
            SET
                username = :username,
                email = :email,
                updated_at = NOW()
            WHERE id_user = :id_user
        ";

            $statement = $this->db->prepare($sql);
        }

        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':id_user', $idUser, PDO::PARAM_INT);

        return $statement->execute();
    }

    /**
     * Modifie l'avatar d'un utilisateur.
     */
    public function updateAvatar(int $idUser, string $avatar): bool
    {
        $sql = "
        UPDATE Users
        SET
            avatar = :avatar,
            updated_at = NOW()
        WHERE id_user = :id_user
    ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(':avatar', $avatar, PDO::PARAM_STR);
        $statement->bindValue(':id_user', $idUser, PDO::PARAM_INT);

        return $statement->execute();
    }
}