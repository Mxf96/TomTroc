<?php

class View
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function render(string $view, array $data = []): void
    {
        // Rend les données disponibles dans la vue
        extract($data);

        // Capture le contenu de la vue
        ob_start();
        require './views/' . $view . '.php';
        $pageContent = ob_get_clean();

        // Titre de la page
        $title = $this->title;

        // Chargement du template principal
        require MAIN_VIEW_PATH;
    }
}