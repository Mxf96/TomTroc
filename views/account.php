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

<section class="account">
    <div class="account__container">
        <h1>Mon compte</h1>

        <?php if (!empty($errorMessage)): ?>

            <p class="account__message account__message--error">
                <?= htmlspecialchars($errorMessage) ?>
            </p>

        <?php endif; ?>


        <?php if (!empty($successMessage)): ?>

            <p class="account__message account__message--success">
                <?= htmlspecialchars($successMessage) ?>
            </p>

        <?php endif; ?>

        <!-- ===========================
            INFORMATIONS UTILISATEUR
        =========================== -->

        <div class="account__top">

            <!-- Profil -->
            <section class="account__profile">

                <div class="account__avatar">
                    <img
                        src="<?= htmlspecialchars($avatar) ?>"
                        alt="Photo de profil de <?= htmlspecialchars($user['username']) ?>">
                </div>

                <form
                    action="index.php?action=account"
                    method="POST"
                    enctype="multipart/form-data"
                    class="account__avatar-form">

                    <input
                        type="hidden"
                        name="form_type"
                        value="avatar">

                    <input
                        type="file"
                        id="avatar"
                        name="avatar"
                        class="account__avatar-input"
                        accept=".png,.jpg,.jpeg,.webp,.avif"
                        onchange="this.form.submit()">

                    <label
                        for="avatar"
                        class="account__edit-avatar">
                        modifier
                    </label>

                </form>

                <div class="account__separator"></div>

                <h2>
                    <?= htmlspecialchars($user['username']) ?>
                </h2>

                <p class="account__member-since">
                    Membre depuis
                    <?= $membershipDuration >= 1
                        ? $membershipDuration . ' an' . ($membershipDuration > 1 ? 's' : '')
                        : 'moins d\'un an'
                    ?>
                </p>

                <div class="account__library">
                    <span>BIBLIOTHÈQUE</span>

                    <p class="account__library-count">
                        <img
                            src="./assets/img/icons/Vector.svg"
                            alt=""
                            class="account__library-icon">

                        <span>
                            <?= count($books) ?>
                            livre<?= count($books) > 1 ? 's' : '' ?>
                        </span>
                    </p>
                </div>
            </section>

            <!-- Formulaire -->
            <section class="account__information">
                <h2>Vos informations personnelles</h2>

                <form
                    action="index.php?action=account"
                    method="POST"
                    novalidate>

                    <input
                        type="hidden"
                        name="form_type"
                        value="information">

                    <div class="account__field">
                        <label for="email">
                            Adresse email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= htmlspecialchars($user['email']) ?>">
                    </div>

                    <div class="account__field">
                        <label for="password">
                            Mot de passe
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="new-password">
                    </div>

                    <div class="account__field">
                        <label for="username">
                            Pseudo
                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="<?= htmlspecialchars($user['username']) ?>">
                    </div>

                    <button
                        type="submit"
                        class="account__save">
                        Enregistrer
                    </button>
                </form>
            </section>
        </div>

        <!-- ===========================
            LIVRES DE L'UTILISATEUR
        =========================== -->

        <div class="account__books-actions">
            <a
                href="index.php?action=addBook"
                class="account__add-book">
                Ajouter un livre
            </a>
        </div>

        <section class="account__books">

            <div class="account__books-header">
                <span>Photo</span>
                <span>Titre</span>
                <span>Auteur</span>
                <span>Description</span>
                <span>Disponibilité</span>
                <span>Action</span>
            </div>

            <?php foreach ($books as $book): ?>

                <article class="account__book">

                    <!-- Image -->
                    <div class="account__book-image">
                        <img
                            src="<?= htmlspecialchars($book['image']) ?>"
                            alt="<?= htmlspecialchars($book['title']) ?>">
                    </div>

                    <!-- Titre -->
                    <div class="account__book-title">
                        <?= htmlspecialchars($book['title']) ?>
                    </div>

                    <!-- Auteur -->
                    <div class="account__book-author">
                        <?= htmlspecialchars($book['author']) ?>
                    </div>

                    <!-- Description -->
                    <div class="account__book-description">
                        <?= htmlspecialchars($book['description']) ?>
                    </div>

                    <!-- Statut -->
                    <div class="account__book-status">

                        <?php if ($book['status'] === 'available'): ?>

                            <span class="status status--available">
                                disponible
                            </span>

                        <?php else: ?>

                            <span class="status status--unavailable">
                                non dispo.
                            </span>

                        <?php endif; ?>

                    </div>

                    <!-- Actions -->
                    <div class="account__book-actions">

                        <a href="index.php?action=editBook&id=<?= (int) $book['id_book'] ?>">
                            Éditer
                        </a>

                        <form
                            action="index.php?action=deleteBook"
                            method="POST"
                            onsubmit="return confirm('Voulez-vous vraiment supprimer ce livre ?');">

                            <input
                                type="hidden"
                                name="id"
                                value="<?= (int) $book['id_book'] ?>">

                            <button
                                type="submit"
                                class="delete">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </article>

            <?php endforeach; ?>

        </section>
    </div>
</section>