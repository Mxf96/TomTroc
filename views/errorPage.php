<?php

/**
 * @var string $errorMessage
 */

$errorMessage = $errorMessage ?? "Une erreur inattendue est survenue.";

?>

<section class="error-page">
    <div class="error-page__content">
        <p class="error-page__code">
            Oups !
        </p>

        <h1>Une erreur est survenue</h1>

        <p class="error-page__message">
            <?= htmlspecialchars($errorMessage) ?>
        </p>

        <a
            href="index.php?action=home"
            class="error-page__button">
            Retour à l'accueil
        </a>
    </div>
</section>