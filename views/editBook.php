<?php

/**
 * @var array $book
 */

?>

<section class="edit-book">
    <div class="edit-book__container">
        <a
            href="index.php?action=account"
            class="edit-book__back">
            ← retour
        </a>

        <h1>Modifier les informations</h1>

        <?php if (!empty($errorMessage)): ?>
            <p class="edit-book__error">
                <?= htmlspecialchars($errorMessage) ?>
            </p>
        <?php endif; ?>

        <form
            action="index.php?action=editBook&id=<?= (int) $book['id_book'] ?>"
            method="POST"
            enctype="multipart/form-data"
            class="edit-book__form"
            novalidate>

            <!-- ===========================
                PHOTO
            =========================== -->

            <div class="edit-book__photo">
                <label>Photo</label>

                <div class="edit-book__image">
                    <img
                        id="bookImagePreview"
                        src="<?= htmlspecialchars($book['image']) ?>"
                        alt="<?= htmlspecialchars($book['title']) ?>">
                </div>

                <div class="edit-book__photo-action">

                    <input
                        type="file"
                        id="image"
                        name="image"
                        class="edit-book__image-input"
                        accept=".png,.jpg,.jpeg,.webp,.avif">

                    <label
                        for="image"
                        class="edit-book__image-label">
                        Modifier la photo
                    </label>
                </div>
            </div>

            <!-- ===========================
                INFORMATIONS
            =========================== -->

            <div class="edit-book__fields">
                <div class="edit-book__field">
                    <label for="title">
                        Titre
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="<?= htmlspecialchars($book['title']) ?>">
                </div>

                <div class="edit-book__field">
                    <label for="author">
                        Auteur
                    </label>

                    <input
                        type="text"
                        id="author"
                        name="author"
                        value="<?= htmlspecialchars($book['author']) ?>">
                </div>

                <div class="edit-book__field">
                    <label for="description">
                        Commentaire
                    </label>

                    <textarea
                        id="description"
                        name="description"><?= htmlspecialchars($book['description']) ?></textarea>
                </div>

                <div class="edit-book__field">
                    <label for="status">
                        Disponibilité
                    </label>

                    <select
                        id="status"
                        name="status">

                        <option
                            value="available"
                            <?= $book['status'] === 'available' ? 'selected' : '' ?>>
                            disponible
                        </option>

                        <option
                            value="unavailable"
                            <?= $book['status'] === 'unavailable' ? 'selected' : '' ?>>
                            non disponible
                        </option>

                    </select>
                </div>

                <button
                    type="submit"
                    class="edit-book__button">
                    Valider
                </button>
            </div>
        </form>
    </div>
</section>