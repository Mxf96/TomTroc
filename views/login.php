<section class="login">

    <!-- Partie formulaire -->
    <div class="login__form-container">
        <div class="login__form-content">
            <h1>Connexion</h1>

            <?php if (!empty($errorMessage)): ?>
                <p class="login__error">
                    <?= htmlspecialchars($errorMessage) ?>
                </p>
            <?php endif; ?>

            <form
                class="login__form"
                action="index.php?action=login"
                method="POST"
                novalidate>

                <div class="login__field">
                    <label for="email">
                        Adresse email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= htmlspecialchars($email ?? '') ?>"
                        autocomplete="email">

                </div>

                <div class="login__field">
                    <label for="password">
                        Mot de passe
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="current-password">

                </div>

                <button
                    type="submit"
                    class="login__button">
                    Se connecter
                </button>

            </form>

            <p class="login__connection">
                Pas de compte ?
                <a href="index.php?action=register">
                    Inscrivez-vous
                </a>
            </p>
        </div>
    </div>

    <!-- Partie image -->
    <div class="login__image">
        <img
            src="./assets/img/logos/marialaura-gionfriddo-50G3FvyQxX0-unsplash 1.svg"
            alt="Bibliothèque remplie de livres">
    </div>
</section>