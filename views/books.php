<?php

/**
 * @var array $books
 * @var string $search
 */

$books = $books ?? [];
$search = $search ?? '';

?>

<section class="books">
    <div class="books__container">

        <!-- ===========================
             EN-TÊTE
        =========================== -->

        <div class="books__header">
            <h1>
                Nos livres à l'échange
            </h1>

            <form
                class="books__search"
                action="index.php"
                method="GET">

                <input
                    type="hidden"
                    name="action"
                    value="books">

                <input
                    type="search"
                    id="book-search"
                    name="search"
                    value="<?= htmlspecialchars($search) ?>"
                    placeholder="Rechercher un livre"
                    aria-label="Rechercher un livre"
                    autocomplete="off">
            </form>
        </div>


        <!-- ===========================
             LISTE DES LIVRES
        =========================== -->

        <div
            class="books__list"
            id="books-list">

            <?php foreach ($books as $book): ?>

                <article
                    class="book-card"
                    data-title="<?= htmlspecialchars($book['title']) ?>"
                    data-author="<?= htmlspecialchars($book['author']) ?>">

                    <a
                        href="index.php?action=book&id=<?= (int) $book['id_book'] ?>">

                        <!-- Image -->
                        <div class="book-card__image">
                            <img
                                src="<?= htmlspecialchars($book['image']) ?>"
                                alt="<?= htmlspecialchars($book['title']) ?>">

                            <?php if ($book['status'] !== 'available'): ?>

                                <span class="book-card__status">
                                    non dispo.
                                </span>

                            <?php endif; ?>

                        </div>

                        <!-- Informations -->
                        <div class="book-card__content">

                            <h2>
                                <?= htmlspecialchars($book['title']) ?>
                            </h2>

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

        <!-- ===========================
             AUCUN RÉSULTAT
        =========================== -->
        <p
            class="books__no-result"
            id="books-no-result"
            <?= !empty($books) ? 'hidden' : '' ?>>

            Aucun livre ne correspond à votre recherche.

        </p>
    </div>
</section>