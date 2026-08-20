<?php

/**
 * @var array $user
 * @var array $books
 */

$avatar = !empty($user['avatar'])
    ? $user['avatar']
    : './assets/img/pictures/default.png';

$createdAt = new DateTime($user['created_at']);
$today = new DateTime();

$membershipDuration = $createdAt->diff($today)->y;

?>

<section class="profile">
    <div class="profile__container">
        <!-- ===========================
             PROFIL UTILISATEUR
        =========================== -->

        <section class="profile__user">
            <div class="profile__avatar">
                <img
                    src="<?= htmlspecialchars($avatar) ?>"
                    alt="Photo de profil de <?= htmlspecialchars($user['username']) ?>">
            </div>

            <div class="profile__separator"></div>

            <h1>
                <?= htmlspecialchars($user['username']) ?>
            </h1>

            <p class="profile__member-since">
                Membre depuis
                <?= $membershipDuration >= 1
                    ? $membershipDuration . ' an' . ($membershipDuration > 1 ? 's' : '')
                    : 'moins d\'un an'
                ?>
            </p>

            <div class="profile__library">
                <span>BIBLIOTHÈQUE</span>

                <p>
                    <img
                        src="./assets/img/icons/Vector.svg"
                        alt="">

                    <span>
                        <?= count($books) ?>
                        livre<?= count($books) > 1 ? 's' : '' ?>
                    </span>
                </p>
            </div>

            <a
                href="<?= isset($_SESSION['user'])
                            ? 'index.php?action=messages&user_id=' . (int) $user['id_user']
                            : 'index.php?action=login'
                        ?>"
                class="profile__message">
                Écrire un message
            </a>
        </section>

        <!-- ===========================
             LIVRES DE L'UTILISATEUR
        =========================== -->
        <section class="profile__books">
            <div class="profile__books-header">
                <span>Photo</span>
                <span>Titre</span>
                <span>Auteur</span>
                <span>Description</span>
            </div>

            <?php foreach ($books as $book): ?>

                <a
                    href="index.php?action=book&id=<?= (int) $book['id_book'] ?>"
                    class="profile__book">

                    <!-- Photo -->
                    <div class="profile__book-image">
                        <img
                            src="<?= htmlspecialchars($book['image']) ?>"
                            alt="<?= htmlspecialchars($book['title']) ?>">
                    </div>

                    <!-- Titre -->
                    <div class="profile__book-title">
                        <?= htmlspecialchars($book['title']) ?>
                    </div>

                    <!-- Auteur -->
                    <div class="profile__book-author">
                        <?= htmlspecialchars($book['author']) ?>
                    </div>

                    <!-- Description -->
                    <div class="profile__book-description">
                        <?= htmlspecialchars($book['description']) ?>
                    </div>
                </a>

            <?php endforeach; ?>

        </section>
    </div>
</section>