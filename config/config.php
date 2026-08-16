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
// Chargement du fichier .env
// ===========================

$envPath = dirname(__DIR__) . '/.env';

if (!file_exists($envPath)) {
    die('Erreur : le fichier .env est introuvable.');
}

$env = parse_ini_file($envPath);

if ($env === false) {
    die('Erreur : impossible de lire le fichier .env.');
}


// ===========================
// Configuration base de données
// ===========================

define('DB_HOST', $env['DB_HOST']);
define('DB_NAME', $env['DB_NAME']);
define('DB_USER', $env['DB_USER']);
define('DB_PASS', $env['DB_PASS']);


// ===========================
// Connexion à la base de données
// ===========================

try {

    $db = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS
    );

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {

    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}