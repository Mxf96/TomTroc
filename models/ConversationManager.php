<?php

class ConversationManager
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Récupère toutes les conversations d'un utilisateur.
     * Les conversations contenant des messages non lus
     * sont affichées en premier.
     */
    public function getConversationsByUser(int $idUser): array
    {
        $sql = "
        SELECT
            c.id_conversation,
            c.created_at,

            u.id_user,
            u.username,
            u.avatar,

            (
                SELECT m.content
                FROM Messages m
                WHERE m.id_conversation = c.id_conversation
                ORDER BY m.created_at DESC, m.id_message DESC
                LIMIT 1
            ) AS last_message,

            (
                SELECT m.created_at
                FROM Messages m
                WHERE m.id_conversation = c.id_conversation
                ORDER BY m.created_at DESC, m.id_message DESC
                LIMIT 1
            ) AS last_message_date,

            (
                SELECT COUNT(*)
                FROM Messages m
                WHERE m.id_conversation = c.id_conversation
                AND m.id_user != :unread_user
                AND m.is_read = 0
            ) AS unread_count

        FROM Conversations c

        INNER JOIN Users_Conversation uc
            ON uc.id_conversation = c.id_conversation

        INNER JOIN Users_Conversation other_uc
            ON other_uc.id_conversation = c.id_conversation
            AND other_uc.id_user != :other_user

        INNER JOIN Users u
            ON u.id_user = other_uc.id_user

        WHERE uc.id_user = :current_user

        ORDER BY
            unread_count DESC,
            COALESCE(last_message_date, c.created_at) DESC
    ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(
            ':unread_user',
            $idUser,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':other_user',
            $idUser,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':current_user',
            $idUser,
            PDO::PARAM_INT
        );

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie qu'une conversation appartient bien
     * à l'utilisateur et récupère l'autre participant.
     */
    public function getConversationById(
        int $idConversation,
        int $idUser
    ): array|false {

        $sql = "
            SELECT
                c.id_conversation,
                c.created_at,

                u.id_user,
                u.username,
                u.avatar

            FROM Conversations c

            INNER JOIN Users_Conversation uc
                ON uc.id_conversation = c.id_conversation

            INNER JOIN Users_Conversation other_uc
                ON other_uc.id_conversation = c.id_conversation
                AND other_uc.id_user != :id_user

            INNER JOIN Users u
                ON u.id_user = other_uc.id_user

            WHERE c.id_conversation = :id_conversation
            AND uc.id_user = :id_user

            LIMIT 1
        ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(
            ':id_conversation',
            $idConversation,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':id_user',
            $idUser,
            PDO::PARAM_INT
        );

        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Recherche une conversation existante entre deux utilisateurs.
     */
    public function findConversationBetweenUsers(
        int $firstUserId,
        int $secondUserId
    ): int|false {

        $sql = "
            SELECT uc1.id_conversation

            FROM Users_Conversation uc1

            INNER JOIN Users_Conversation uc2
                ON uc1.id_conversation = uc2.id_conversation

            WHERE uc1.id_user = :first_user
            AND uc2.id_user = :second_user

            LIMIT 1
        ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(
            ':first_user',
            $firstUserId,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':second_user',
            $secondUserId,
            PDO::PARAM_INT
        );

        $statement->execute();

        $conversation = $statement->fetch(PDO::FETCH_ASSOC);

        if ($conversation === false) {
            return false;
        }

        return (int) $conversation['id_conversation'];
    }

    /**
     * Crée une nouvelle conversation entre deux utilisateurs.
     */
    public function createConversation(
        int $firstUserId,
        int $secondUserId
    ): int {

        // Création de la conversation.
        $sql = "
            INSERT INTO Conversations (created_at)
            VALUES (NOW())
        ";

        $statement = $this->db->prepare($sql);
        $statement->execute();

        $idConversation = (int) $this->db->lastInsertId();

        // Ajout du premier utilisateur.
        $sql = "
            INSERT INTO Users_Conversation (
                id_user,
                id_conversation
            )
            VALUES (
                :id_user,
                :id_conversation
            )
        ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(
            ':id_user',
            $firstUserId,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':id_conversation',
            $idConversation,
            PDO::PARAM_INT
        );

        $statement->execute();

        // Ajout du deuxième utilisateur.
        $statement = $this->db->prepare($sql);

        $statement->bindValue(
            ':id_user',
            $secondUserId,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':id_conversation',
            $idConversation,
            PDO::PARAM_INT
        );

        $statement->execute();

        return $idConversation;
    }
}