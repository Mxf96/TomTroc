<?php

// Démarrage de la session
session_start();


// ===========================
// Configuration des chemins
// ===========================

// Chemin vers les templates principaux
define('TEMPLATE_VIEW_PATH', './views/templates/');

// Template principal
define('MAIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'main.php');


// ===========================
// Configuration base de données
// ===========================
// À activer lorsque la partie BDD commencera

// define('DB_HOST', 'localhost');
// define('DB_NAME', 'tomtroc');
// define('DB_USER', 'root');
// define('DB_PASS', '');