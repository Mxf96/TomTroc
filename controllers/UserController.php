<?php

class UserController
{
    private UserManager $userManager;

    public function __construct(PDO $db)
    {
        $this->userManager = new UserManager($db);
    }

    /**
     * Affiche et traite le formulaire d'inscription.
     */
    public function register(): void
    {
        // Si le formulaire n'a pas encore été envoyé,
        // on affiche simplement la page.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            $view = new View('Inscription');
            $view->render('register');

            return;
        }

        // ===========================
        // Récupération des données
        // ===========================

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // ===========================
        // Validation
        // ===========================

        if (
            empty($username)
            || empty($email)
            || empty($password)
        ) {
            $this->showRegisterError(
                'Tous les champs sont obligatoires.'
            );

            return;
        }

        // Vérification de l'adresse email

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $this->showRegisterError(
                "L'adresse email n'est pas valide."
            );

            return;
        }

        // Vérification du mot de passe

        if (strlen($password) < 8) {

            $this->showRegisterError(
                'Le mot de passe doit contenir au moins 8 caractères.'
            );

            return;
        }

        // Vérification du pseudo

        if ($this->userManager->usernameExists($username)) {

            $this->showRegisterError(
                'Ce pseudo est déjà utilisé.'
            );

            return;
        }

        // Vérification de l'email

        if ($this->userManager->emailExists($email)) {

            $this->showRegisterError(
                'Cette adresse email est déjà utilisée.'
            );

            return;
        }

        // ===========================
        // Hash du mot de passe
        // ===========================

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        // ===========================
        // Création utilisateur
        // ===========================

        $success = $this->userManager->createUser(
            $username,
            $email,
            $hashedPassword
        );


        if (!$success) {

            $this->showRegisterError(
                "Une erreur est survenue pendant l'inscription."
            );

            return;
        }

        // ===========================
        // Redirection connexion
        // ===========================

        header('Location: index.php?action=login');
        exit;
    }

    /**
     * Affiche et traite le formulaire de connexion.
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            $view = new View('Connexion');
            $view->render('login');

            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {

            $this->showLoginError(
                'Tous les champs sont obligatoires.'
            );

            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $this->showLoginError(
                "L'adresse email n'est pas valide."
            );

            return;
        }

        $user = $this->userManager->getUserByEmail($email);

        if ($user === false) {

            $this->showLoginError(
                'Adresse email ou mot de passe incorrect.'
            );

            return;
        }

        if (!password_verify($password, $user['password'])) {

            $this->showLoginError(
                'Adresse email ou mot de passe incorrect.'
            );

            return;
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id_user' => $user['id_user'],
            'username' => $user['username'],
            'email' => $user['email'],
            'avatar' => $user['avatar']
        ];

        header('Location: index.php?action=home');
        exit;
    }

    /**
     * Réaffiche le formulaire avec un message d'erreur.
     */
    private function showRegisterError(string $message): void
    {
        $view = new View('Inscription');

        $view->render('register', [
            'errorMessage' => $message
        ]);
    }

    /**
     * Affiche une erreur de connexion.
     */
    private function showLoginError(string $message): void
    {
        $view = new View('Connexion');

        $view->render('login', [
            'errorMessage' => $message
        ]);
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function logout(): void
    {
        // Supprime toutes les données stockées dans la session
        $_SESSION = [];

        // Détruit la session
        session_destroy();

        // Redirection vers la page d'accueil
        header('Location: index.php?action=home');
        exit;
    }
}