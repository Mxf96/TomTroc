<?php

/**
 * @var array $book
 */

?>

<section class="book-details">

    <!-- Fil d'Ariane -->
    <div class="book-details__breadcrumb">
        <a href="index.php?action=books">
            Nos livres
        </a>

        <span> &gt; </span>

        <span>
            <?= htmlspecialchars($book['title']) ?>
        </span>
    </div>

    <div class="book-details__container">

        <!-- Image du livre -->
        <div class="book-details__image">
            <img
                src="<?= htmlspecialchars($book['image']) ?>"
                alt="<?= htmlspecialchars($book['title']) ?>">

        </div>

        <!-- Informations -->
        <div class="book-details__content">
            <h1>
                <?= htmlspecialchars($book['title']) ?>
            </h1>

            <p class="book-details__author">
                par <?= htmlspecialchars($book['author']) ?>
            </p>

            <div class="book-details__separator"></div>

            <!-- Description -->
            <div class="book-details__description">
                <h2>Description</h2>

                <p>
                    <?= nl2br(htmlspecialchars($book['description'])) ?>
                </p>
            </div>

            <!-- Propriétaire -->
            <div class="book-details__owner">
                <h2>Propriétaire</h2>

                <a
                    href="index.php?action=account&id=<?= (int) $book['id_user'] ?>"
                    class="book-details__owner-card">

                    <?php
                    $avatar = !empty($book['avatar'])
                        ? $book['avatar']
                        : './assets/img/pictures/default.png';
                    ?>

                    <img
                        src="<?= htmlspecialchars($avatar) ?>"
                        alt="Avatar de <?= htmlspecialchars($book['username']) ?>">

                    <span>
                        <?= htmlspecialchars($book['username']) ?>
                    </span>
                </a>
            </div>

            <!-- Bouton -->
            <a
                href="index.php?action=messages"
                class="book-details__message">
                Envoyer un message
            </a>
        </div>
    </div>
</section>