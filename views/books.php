<?php

$books = $books ?? [];

?>

<section class="books">
    <div class="books__container">
        <div class="books__header">
            <h1>Nos livres à l'échange</h1>

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
                    name="search"
                    placeholder="Rechercher un livre"
                    aria-label="Rechercher un livre">
            </form>
        </div>

        <!-- Liste des livres -->
        <div class="books__list">
            <?php foreach ($books as $book): ?>
                <article class="book-card">
                    <a href="index.php?action=book&id=<?= htmlspecialchars($book['id_book']) ?>">
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

                        <div class="book-card__content">
                            <h2> <?= htmlspecialchars($book['title']) ?> </h2>

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
    </div>
</section>