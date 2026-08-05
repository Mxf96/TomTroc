<?php

/**
 * Chargement automatique des classes.
 */
spl_autoload_register(function ($className) {

    $directories = [
        'controllers/',
        'models/',
        'services/',
        'views/'
    ];

    foreach ($directories as $directory) {

        $file = $directory . $className . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
