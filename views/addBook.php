<?php

/**
 * Page d'ajout d'un livre.
 */

?>

<section class="add-book">
    <div class="add-book__container">

        <!-- Retour -->
        <a
            href="index.php?action=account"
            class="add-book__back">
            ← retour
        </a>

        <h1>
            Ajouter un livre
        </h1>

        <!-- Message d'erreur -->
        <?php if (!empty($errorMessage)): ?>

            <p class="add-book__error">
                <?= htmlspecialchars($errorMessage) ?>
            </p>

        <?php endif; ?>

        <!-- ===========================
             FORMULAIRE
        =========================== -->

        <form
            action="index.php?action=addBook"
            method="POST"
            enctype="multipart/form-data"
            class="add-book__form"
            novalidate>

            <!-- ===========================
                 PHOTO
            =========================== -->

            <div class="add-book__photo">

                <label>
                    Photo
                </label>

                <div class="add-book__image">

                    <div
                        class="add-book__image-placeholder"
                        id="add-book-image-placeholder">

                        <span>
                            Aucune photo
                        </span>

                    </div>

                    <img
                        src=""
                        alt="Aperçu du livre"
                        id="add-book-image-preview"
                        class="add-book__image-preview"
                        hidden>
                </div>

                <div class="add-book__photo-action">

                    <input
                        type="file"
                        id="image"
                        name="image"
                        class="add-book__image-input"
                        accept=".png,.jpg,.jpeg,.webp,.avif">

                    <label
                        for="image"
                        class="add-book__image-label">
                        Ajouter une photo
                    </label>
                </div>
            </div>

            <!-- ===========================
                 INFORMATIONS
            =========================== -->

            <div class="add-book__fields">

                <!-- Titre -->
                <div class="add-book__field">

                    <label for="title">
                        Titre
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        placeholder="Titre du livre">

                </div>

                <!-- Auteur -->
                <div class="add-book__field">

                    <label for="author">
                        Auteur
                    </label>

                    <input
                        type="text"
                        id="author"
                        name="author"
                        placeholder="Auteur du livre">

                </div>

                <!-- Description -->
                <div class="add-book__field">

                    <label for="description">
                        Commentaire
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        placeholder="Décrivez votre livre"></textarea>

                </div>

                <!-- Disponibilité -->
                <div class="add-book__field">

                    <label for="status">
                        Disponibilité
                    </label>

                    <select
                        id="status"
                        name="status">

                        <option
                            value="available"
                            selected>
                            disponible
                        </option>

                        <option value="unavailable">
                            non disponible
                        </option>
                    </select>
                </div>

                <!-- Bouton -->
                <button
                    type="submit"
                    class="add-book__button">
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</section>