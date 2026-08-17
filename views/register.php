<section class="login">
    <!-- Partie formulaire -->
    <div class="login__form-container">
        <div class="login__form-content">
            <h1>Inscription</h1>

            <form
                class="login__form"
                action="index.php?action=login"
                method="POST">

                <div class="login__field">
                    <label for="username">Pseudo</label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        autocomplete="username">
                </div>

                <div class="login__field">
                    <label for="email">Adresse email</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        autocomplete="email">
                </div>

                <div class="login__field">
                    <label for="password">Mot de passe</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="new-password">
                </div>

                <button
                    type="submit"
                    class="login__button">
                    S'inscrire
                </button>
            </form>

            <p class="login__connection">
                Déjà inscrit ?
                <a href="index.php?action=login">
                    Connectez-vous
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