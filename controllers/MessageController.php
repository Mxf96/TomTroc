<?php

class MessageController
{
    private ConversationManager $conversationManager;
    private MessageManager $messageManager;
    private UserManager $userManager;

    public function __construct(PDO $db)
    {
        $this->conversationManager = new ConversationManager($db);
        $this->messageManager = new MessageManager($db);
        $this->userManager = new UserManager($db);
    }

    /**
     * Affiche la messagerie.
     */
    public function showMessages(): void
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
        // NOUVELLE CONVERSATION
        // ===========================

        $targetUserId = (int) Utils::request(
            'user_id',
            0
        );

        if ($targetUserId > 0) {

            // Empêche de discuter avec soi-même.
            if ($targetUserId === $idUser) {

                header('Location: index.php?action=messages');
                exit;
            }

            // Vérifie que l'utilisateur cible existe.
            $targetUser = $this->userManager->getUserById(
                $targetUserId
            );

            if ($targetUser === false) {
                throw new Exception(
                    "L'utilisateur demandé n'existe pas."
                );
            }

            // Recherche d'une conversation existante.
            $idConversation =
                $this->conversationManager
                ->findConversationBetweenUsers(
                    $idUser,
                    $targetUserId
                );

            // Sinon on en crée une.
            if ($idConversation === false) {

                $idConversation =
                    $this->conversationManager
                    ->createConversation(
                        $idUser,
                        $targetUserId
                    );
            }

            // Redirection vers la conversation.
            header(
                'Location: index.php?action=messages'
                    . '&conversation_id='
                    . $idConversation
            );

            exit;
        }

        // ===========================
        // LISTE DES CONVERSATIONS
        // ===========================

        $conversations =
            $this->conversationManager
            ->getConversationsByUser($idUser);


        $currentConversation = null;
        $messages = [];

        // ===========================
        // CONVERSATION SÉLECTIONNÉE
        // ===========================

        $idConversation = (int) Utils::request(
            'conversation_id',
            0
        );

        if ($idConversation > 0) {

            /*
             * Cette méthode vérifie aussi que
             * l'utilisateur connecté appartient
             * bien à la conversation.
             */
            $currentConversation =
                $this->conversationManager
                ->getConversationById(
                    $idConversation,
                    $idUser
                );

            if ($currentConversation === false) {

                throw new Exception(
                    "Cette conversation n'existe pas ou vous n'y avez pas accès."
                );
            }

            // Marque les messages reçus comme lus
            $this->messageManager
                ->markConversationAsRead(
                    $idConversation,
                    $idUser
                );

            // Met immédiatement à jour le compteur du header
            $_SESSION['unread_message_count'] =
                $this->messageManager
                ->getUnreadCountByUser(
                    $idUser
                );

            // Récupère les messages

            $messages =
                $this->messageManager
                ->getMessagesByConversation(
                    $idConversation
                );
        }

        // ===========================
        // AFFICHAGE
        // ===========================

        $view = new View('Messagerie');

        $view->render('messages', [
            'conversations' => $conversations,
            'currentConversation' => $currentConversation,
            'messages' => $messages
        ]);
    }

    /**
     * Envoie un message.
     */
    public function sendMessage(): void
    {
        // ===========================
        // UTILISATEUR CONNECTÉ
        // ===========================

        if (!isset($_SESSION['user'])) {

            header('Location: index.php?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            throw new Exception(
                "Méthode non autorisée."
            );
        }

        $idUser = (int) $_SESSION['user']['id_user'];

        $idConversation =
            (int) ($_POST['conversation_id'] ?? 0);

        $content = trim(
            $_POST['content'] ?? ''
        );

        // ===========================
        // VALIDATION
        // ===========================

        if ($idConversation <= 0) {

            throw new Exception(
                "Conversation invalide."
            );
        }

        if ($content === '') {

            header(
                'Location: index.php?action=messages'
                    . '&conversation_id='
                    . $idConversation
            );

            exit;
        }

        // ===========================
        // VÉRIFICATION ACCÈS
        // ===========================

        $conversation =
            $this->conversationManager
            ->getConversationById(
                $idConversation,
                $idUser
            );


        if ($conversation === false) {

            throw new Exception(
                "Vous n'êtes pas autorisé à envoyer un message dans cette conversation."
            );
        }

        // ===========================
        // ENREGISTREMENT
        // ===========================

        $this->messageManager->createMessage(
            $idConversation,
            $idUser,
            $content
        );

        // ===========================
        // REDIRECTION
        // ===========================

        header(
            'Location: index.php?action=messages'
                . '&conversation_id='
                . $idConversation
        );

        exit;
    }
}