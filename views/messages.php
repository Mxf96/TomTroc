<?php

/**
 * @var array $conversations
 * @var array $messages
 * @var array|null $currentConversation
 */

$conversations = $conversations ?? [];
$messages = $messages ?? [];
$currentConversation = $currentConversation ?? null;

?>

<section class="messages <?= $currentConversation ? 'messages--conversation-open' : '' ?>">

    <!-- ===========================
         LISTE DES CONVERSATIONS
    =========================== -->

    <aside class="messages__sidebar">
        <h1>Messagerie</h1>

        <div class="messages__conversations">

            <?php foreach ($conversations as $conversation): ?>

                <?php
                $conversationAvatar =
                    !empty($conversation['avatar'])
                    ? $conversation['avatar']
                    : './assets/img/pictures/default.png';

                $unreadCount = (int) ($conversation['unread_count'] ?? 0);
                $isUnread = $unreadCount > 0;
                ?>

                <a
                    href="index.php?action=messages&conversation_id=<?= (int) $conversation['id_conversation'] ?>"
                    class="messages__conversation <?= $isUnread ? 'messages__conversation--unread' : '' ?>">

                    <img
                        src="<?= htmlspecialchars($conversationAvatar) ?>"
                        alt="Avatar de <?= htmlspecialchars($conversation['username']) ?>">

                    <div class="messages__conversation-content">
                        <div class="messages__conversation-header">

                            <span class="messages__conversation-name">
                                <?= htmlspecialchars($conversation['username']) ?>
                            </span>

                            <span class="messages__conversation-date">

                                <?php if (!empty($conversation['last_message_date'])): ?>

                                    <?= htmlspecialchars(
                                        date(
                                            'H:i',
                                            strtotime($conversation['last_message_date'])
                                        )
                                    ) ?>

                                <?php endif; ?>

                            </span>
                        </div>

                        <p>
                            <?= htmlspecialchars(
                                $conversation['last_message']
                                    ?? 'Aucun message'
                            ) ?>
                        </p>

                    </div>

                </a>

            <?php endforeach; ?>


            <?php if (empty($conversations)): ?>

                <p class="messages__no-conversation">
                    Vous n'avez aucune conversation.
                </p>

            <?php endif; ?>

        </div>

    </aside>


    <!-- ===========================
         CONVERSATION
    =========================== -->

    <section class="messages__chat">

        <?php if ($currentConversation): ?>

            <?php
            $conversationAvatar =
                !empty($currentConversation['avatar'])
                ? $currentConversation['avatar']
                : './assets/img/pictures/default.png';
            ?>

            <!-- Header -->
            <header class="messages__chat-header">

                <a
                    href="index.php?action=messages"
                    class="messages__back">
                    ← retour
                </a>

                <a href="index.php?action=profile&id=<?= (int) $currentConversation['id_user'] ?>">

                    <img
                        src="<?= htmlspecialchars($conversationAvatar) ?>"
                        alt="Avatar de <?= htmlspecialchars($currentConversation['username']) ?>">

                    <span>
                        <?= htmlspecialchars($currentConversation['username']) ?>
                    </span>
                </a>
            </header>

            <!-- ===========================
                 MESSAGES
            =========================== -->

            <div class="messages__content">

                <?php foreach ($messages as $message): ?>

                    <?php
                    $isMine =
                        (int) $message['id_user']
                        ===
                        (int) $_SESSION['user']['id_user'];
                    ?>

                    <div class="message <?= $isMine ? 'message--mine' : 'message--other' ?>">

                        <div class="message__meta">

                            <?php if (!$isMine): ?>

                                <img
                                    src="<?= htmlspecialchars($conversationAvatar) ?>"
                                    alt="">

                            <?php endif; ?>

                            <span>
                                <?= htmlspecialchars(
                                    date(
                                        'd.m H:i',
                                        strtotime($message['created_at'])
                                    )
                                ) ?>
                            </span>

                        </div>

                        <div class="message__bubble">
                            <?= nl2br(
                                htmlspecialchars(
                                    $message['content']
                                )
                            ) ?>
                        </div>

                    </div>

                <?php endforeach; ?>

                <?php if (empty($messages)): ?>

                    <div class="messages__empty-chat">
                        Aucun message pour le moment.
                    </div>

                <?php endif; ?>

            </div>


            <!-- ===========================
                 ENVOI
            =========================== -->

            <form
                class="messages__form"
                action="index.php?action=sendMessage"
                method="POST">

                <input
                    type="hidden"
                    name="conversation_id"
                    value="<?= (int) $currentConversation['id_conversation'] ?>">


                <input
                    type="text"
                    name="content"
                    placeholder="Tapez votre message ici"
                    autocomplete="off"
                    required>

                <button type="submit">
                    Envoyer
                </button>
            </form>

        <?php else: ?>

            <div class="messages__empty">
                <p>Sélectionnez une conversation.</p>
            </div>

        <?php endif; ?>

    </section>
</section>