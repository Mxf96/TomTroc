<?php

$books = $books ?? [];

?>

<section class="home">

    <!-- Section de présentation -->
    <section class="home__hero">

        <div class="home__hero-content">

            <h1> Rejoignez nos<br>
                lecteurs passionnés</h1>
            <p>
                Donnez une nouvelle vie à vos livres en les
                échangeant avec d'autres amoureux de la
                lecture. Nous croyons en la magie du
                partage de connaissances et d'histoires à
                travers les livres.
            </p>
            <a href="index.php?action=books" class="home__button">
                Découvrir
            </a>
        </div>

        <div class="home__hero-image">
            <img
                src="../assets/img/logos/hamza-nouasria-KXrvPthkmYQ-unsplash 1.svg"
                alt="Livres dans une librairie">

            <p>Hamza</p>
        </div>
    </section>

    <!-- Section des derniers livres -->
    <section class="home__books">

        <h2>Les derniers livres ajoutés</h2>

        <div class="home__books-list">
            <?php foreach ($books as $book): ?>
                <article class="book-card">
                    <a href="?page=book&id=<?= htmlspecialchars($book['id_book']) ?>">
                        <img
                            src="<?= htmlspecialchars($book['image']) ?>"
                            alt="<?= htmlspecialchars($book['title']) ?>">
                        <div class="book-card__content">
                            <h3> <?= htmlspecialchars($book['title']) ?> </h3>
                            <p class="book-card__author">
                                <?= htmlspecialchars($book['author']) ?>
                            </p>
                            <p class="book-card__owner">
                                Vendu par :
                                <?= htmlspecialchars($book['username']) ?>
                            </p>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>

        <a href="index.php?action=books" class="home__button home__button--books">
            Voir tous les livres
        </a>
    </section>

    <!-- Section Comment ça marche -->
    <section class="home__how-it-works">

        <div class="home__how-it-works-header">
            <h2>Comment ça marche ?</h2>

            <p>
                Échanger des livres avec TomTroc c'est simple et<br>
                amusant ! Suivez ces étapes pour commencer :
            </p>
        </div>

        <div class="home__steps">

            <article class="home__step">
                <p>
                    Inscrivez-vous<br>
                    gratuitement sur<br>
                    notre plateforme.
                </p>
            </article>

            <article class="home__step">
                <p>
                    Ajoutez les livres que vous<br>
                    souhaitez échanger à<br>
                    votre profil.
                </p>
            </article>

            <article class="home__step">
                <p>
                    Parcourez les livres<br>
                    disponibles chez d'autres<br>
                    membres.
                </p>
            </article>

            <article class="home__step">
                <p>
                    Proposez un échange et<br>
                    discutez avec d'autres<br>
                    passionnés de lecture.
                </p>
            </article>

        </div>

        <a href="?page=books" class="home__button home__button--outline">
            Voir tous les livres
        </a>

    </section>


    <!-- Grande image -->
    <section class="home__banner">
        <img
            src="../assets/img/logos/clay-banks-4uH8rdyEbH4-unsplash 1.svg"
            alt="Bibliothèque remplie de livres">
    </section>


    <!-- Section Nos valeurs -->
    <section class="home__values">

        <div class="home__values-content">

            <h2>Nos valeurs</h2>

            <p>
                Chez Tom Troc, nous mettons l'accent sur le
                partage, la découverte et la communauté. Nos
                valeurs sont ancrées dans notre passion pour les
                livres et notre désir de créer des liens entre les
                lecteurs. Nous croyons en la puissance des histoires
                pour rassembler les gens et inspirer des
                conversations enrichissantes.
            </p>

            <p>
                Notre association a été fondée avec une conviction
                profonde : chaque livre mérite d'être lu et partagé.
            </p>

            <p>
                Nous sommes passionnés par la création d'une
                plateforme conviviale qui permet aux lecteurs de se
                connecter, de partager leurs découvertes littéraires
                et d'échanger des livres qui attendent patiemment
                sur les étagères.
            </p>

            <p class="home__values-signature">
                L'équipe Tom Troc
            </p>

            <div class="home__values-heart">
                <img
                    src="../assets/img/logos/Vector 2.svg"
                    alt="">
            </div>

        </div>

    </section>
</section>