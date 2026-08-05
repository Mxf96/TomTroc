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
</head>

<body>
    <?php require_once TEMPLATE_VIEW_PATH . 'header.php'; ?>
    <main>
        <?= $pageContent ?>
    </main>
    <?php require_once TEMPLATE_VIEW_PATH . 'footer.php'; ?>
</body>

</html>