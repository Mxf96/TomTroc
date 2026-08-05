<?php

class Utils
{
    /**
     * Récupère une variable de $_REQUEST.
     */
    public static function request(string $variableName, mixed $defaultValue = null): mixed
    {
        return $_REQUEST[$variableName] ?? $defaultValue;
    }

    /**
     * Redirige vers une action.
     */
    public static function redirect(string $action, array $params = []): void
    {
        $url = "index.php?action=$action";

        foreach ($params as $name => $value) {
            $url .= "&$name=$value";
        }

        header("Location: $url");
        exit();
    }

    /**
     * Protège une chaîne contre les attaques XSS.
     */
    public static function format(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Demande une confirmation JavaScript.
     */
    public static function askConfirmation(string $message): string
    {
        return "onclick=\"return confirm('$message');\"";
    }
}