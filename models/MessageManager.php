<?php

class MessageManager
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Récupère tous les messages d'une conversation.
     */
    public function getMessagesByConversation(
        int $idConversation
    ): array {

        $sql = "
            SELECT
                m.id_message,
                m.content,
                m.is_read,
                m.created_at,
                m.id_user,
                m.id_conversation,
                u.username,
                u.avatar

            FROM Messages m

            INNER JOIN Users u
                ON u.id_user = m.id_user

            WHERE m.id_conversation = :id_conversation

            ORDER BY
                m.created_at ASC,
                m.id_message ASC
        ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(
            ':id_conversation',
            $idConversation,
            PDO::PARAM_INT
        );

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Enregistre un nouveau message.
     */
    public function createMessage(
        int $idConversation,
        int $idUser,
        string $content
    ): bool {

        $sql = "
            INSERT INTO Messages (
                content,
                is_read,
                created_at,
                id_user,
                id_conversation
            )
            VALUES (
                :content,
                0,
                NOW(),
                :id_user,
                :id_conversation
            )
        ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(
            ':content',
            $content,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':id_user',
            $idUser,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':id_conversation',
            $idConversation,
            PDO::PARAM_INT
        );

        return $statement->execute();
    }

    /**
     * Retourne le nombre de messages non lus
     * pour un utilisateur.
     */
    public function getUnreadCountByUser(int $idUser): int
    {
        $sql = "
        SELECT COUNT(*)

        FROM Messages m

        INNER JOIN Users_Conversation uc
            ON uc.id_conversation = m.id_conversation

        WHERE uc.id_user = :current_user
        AND m.id_user != :sender_user
        AND m.is_read = 0
    ";

        $statement = $this->db->prepare($sql);

        $statement->bindValue(
            ':current_user',
            $idUser,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':sender_user',
            $idUser,
            PDO::PARAM_INT
        );

        $statement->execute();

        return (int) $statement->fetchColumn();
    }

    /**
     * Marque comme lus les messages reçus
     * dans une conversation.
     */
    public function markConversationAsRead(
        int $idConversation,
        int $idUser
    ): bool {

        $sql = "
        UPDATE Messages

        SET is_read = 1

        WHERE id_conversation = :id_conversation
        AND id_user != :id_user
        AND is_read = 0
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

        return $statement->execute();
    }
}