<?php

/**
 * Main template
 * 
 * @var string $pageContent
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TomTroc</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./assets/styles/style.css">
    <link rel="stylesheet" href="./assets/styles/header.css">
    <link rel="stylesheet" href="./assets/styles/footer.css">
    <link rel="stylesheet" href="./assets/styles/home.css">
    <link rel="stylesheet" href="./assets/styles/books.css">
    <link rel="stylesheet" href="./assets/styles/bookDetails.css">
    <link rel="stylesheet" href="./assets/styles/account.css">
    <link rel="stylesheet" href="./assets/styles/login.css">
    <link rel="stylesheet" href="./assets/styles/messages.css">
    <link rel="stylesheet" href="./assets/styles/errorPage.css">
    <link rel="stylesheet" href="./assets/styles/form.css">
    <link rel="stylesheet" href="./assets/styles/editBook.css">
    <link rel="stylesheet" href="./assets/styles/profile.css">
</head>

<body>
    <?php require_once TEMPLATE_VIEW_PATH . 'header.php'; ?>
    <main>
        <?= $pageContent ?>
    </main>
    <?php require_once TEMPLATE_VIEW_PATH . 'footer.php'; ?>

    <script>

        // Menu Burger
        const burgerButton = document.querySelector('.burger-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        burgerButton.addEventListener('click', () => {
            burgerButton.classList.toggle('active');
            mobileMenu.classList.toggle('active');

            const isOpen = mobileMenu.classList.contains('active');

            burgerButton.setAttribute('aria-expanded', isOpen);
        });

        // Trie Dynamique
        const searchInput = document.querySelector('#book-search');
        const bookCards = document.querySelectorAll('.book-card');
        const noResultMessage = document.querySelector('#books-no-result');


        /**
         * Normalise une chaîne afin de faciliter la recherche.
         * Exemple :
         * "Été" devient "ete".
         */
        function normalizeText(text) {
            return text
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '');
        }

        searchInput.addEventListener('input', function() {
            const search = normalizeText(this.value.trim());

            let visibleBooks = 0;

            bookCards.forEach(function(bookCard) {

                const title = normalizeText(bookCard.dataset.title);
                const author = normalizeText(bookCard.dataset.author);

                const matchesSearch =
                    title.includes(search) ||
                    author.includes(search);

                if (matchesSearch) {

                    bookCard.style.display = '';
                    visibleBooks++;
                } else {

                    bookCard.style.display = 'none';

                }
            });

            // Affiche le message uniquement si aucun livre ne correspond.
            noResultMessage.hidden = visibleBooks !== 0;
        });
    </script>
</body>
</html>