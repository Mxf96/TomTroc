<header>
    <div class="header-left">
        <a href="index.php?action=home">
            <img src="./assets/img/logos/logo.svg" alt="Logo TomTroc">
        </a>

        <nav class="desktop-nav">
            <a href="index.php?action=home">Accueil</a>
            <a href="index.php?action=books">Nos livres à l'échange</a>
        </nav>
    </div>

    <div class="header-right desktop-nav">

        <?php if (isset($_SESSION['user'])): ?>

            <a href="index.php?action=messages">
                <img src="./assets/img/icons/Icon messagerie.svg" alt="">
                <span>Messagerie</span>
            </a>

            <a href="index.php?action=account">
                <img src="./assets/img/icons/Icon mon compte.svg" alt="">
                <span>Mon Compte</span>
            </a>

            <a href="index.php?action=logout">
                Déconnexion
            </a>

        <?php else: ?>

            <a href="index.php?action=login">
                Connexion
            </a>

        <?php endif; ?>
    </div>

    <button
        class="burger-button"
        type="button"
        aria-label="Ouvrir le menu"
        aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <nav class="mobile-menu">
        <a href="index.php?action=home">Accueil</a>

        <a href="index.php?action=books">
            Nos livres à l'échange
        </a>

        <?php if (isset($_SESSION['user'])): ?>

            <a href="index.php?action=messages">
                <img src="./assets/img/icons/Icon messagerie.svg" alt="">
                <span>Messagerie</span>
            </a>

            <a href="index.php?action=account">
                <img src="./assets/img/icons/Icon mon compte.svg" alt="">
                <span>Mon Compte</span>
            </a>

            <a href="index.php?action=logout">
                Déconnexion
            </a>

        <?php else: ?>

            <a href="index.php?action=login">
                Connexion
            </a>

        <?php endif; ?>
    </nav>
</header>