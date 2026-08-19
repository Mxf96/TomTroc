<?php

class UserController
{
    private UserManager $userManager;
    private BookManager $bookManager;
    private UploadService $uploadService;

    public function __construct(PDO $db)
    {
        $this->userManager = new UserManager($db);
        $this->bookManager = new BookManager($db);
        $this->uploadService = new UploadService();
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

    /**
     * Affiche et modifie le compte de l'utilisateur connecté.
     */
    public function account(): void
    {
        // L'utilisateur doit être connecté.
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $idUser = (int) $_SESSION['user']['id_user'];

        // ===========================
        // TRAITEMENT DES FORMULAIRES
        // ===========================

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $formType = $_POST['form_type'] ?? '';

            // Modification des informations personnelles.
            if ($formType === 'information') {

                $this->updateAccountInformation($idUser);

                return;
            }

            // Modification de l'avatar.
            if ($formType === 'avatar') {

                $this->updateAccountAvatar($idUser);

                return;
            }
        }

        // ===========================
        // AFFICHAGE DU COMPTE
        // ===========================

        $this->renderAccount($idUser);
    }

    /**
     * Modifie les informations personnelles.
     */
    private function updateAccountInformation(int $idUser): void
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($email)) {

            $this->renderAccount(
                $idUser,
                "Le pseudo et l'adresse email sont obligatoires."
            );

            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $this->renderAccount(
                $idUser,
                "L'adresse email n'est pas valide."
            );

            return;
        }

        if (
            $this->userManager->usernameExistsForOtherUser(
                $username,
                $idUser
            )
        ) {

            $this->renderAccount(
                $idUser,
                'Ce pseudo est déjà utilisé.'
            );

            return;
        }

        if (
            $this->userManager->emailExistsForOtherUser(
                $email,
                $idUser
            )
        ) {

            $this->renderAccount(
                $idUser,
                'Cette adresse email est déjà utilisée.'
            );

            return;
        }

        // Si le champ mot de passe est vide,
        // l'ancien mot de passe reste inchangé.
        $hashedPassword = null;

        if (!empty($password)) {

            if (strlen($password) < 8) {

                $this->renderAccount(
                    $idUser,
                    'Le mot de passe doit contenir au moins 8 caractères.'
                );

                return;
            }

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        $this->userManager->updateUser(
            $idUser,
            $username,
            $email,
            $hashedPassword
        );

        // Mise à jour des informations conservées dans la session.
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['email'] = $email;

        $this->renderAccount(
            $idUser,
            null,
            'Vos informations ont bien été modifiées.'
        );
    }

    /**
     * Modifie la photo de profil.
     */
    private function updateAccountAvatar(int $idUser): void
    {
        if (!isset($_FILES['avatar'])) {

            $this->renderAccount(
                $idUser,
                "Aucune image n'a été sélectionnée."
            );

            return;
        }

        try {

            $avatar = $this->uploadService->uploadAvatar(
                $_FILES['avatar']
            );

            $this->userManager->updateAvatar(
                $idUser,
                $avatar
            );

            // Mise à jour de la session.
            $_SESSION['user']['avatar'] = $avatar;


            $this->renderAccount(
                $idUser,
                null,
                'Votre photo de profil a bien été modifiée.'
            );
        } catch (Exception $e) {

            $this->renderAccount(
                $idUser,
                $e->getMessage()
            );
        }
    }

    /**
     * Affiche la page du compte.
     */
    private function renderAccount(
        int $idUser,
        ?string $errorMessage = null,
        ?string $successMessage = null
    ): void {

        $user = $this->userManager->getUserById($idUser);

        if ($user === false) {
            throw new Exception(
                "Utilisateur introuvable."
            );
        }


        $books = $this->bookManager->getBooksByUserId(
            $idUser
        );


        $view = new View('Mon compte');

        $view->render('account', [
            'user' => $user,
            'books' => $books,
            'errorMessage' => $errorMessage,
            'successMessage' => $successMessage
        ]);
    }

    /**
     * Affiche le profil public d'un utilisateur.
     */
    public function profile(int $idUser): void
    {
        // Récupération de l'utilisateur.
        $user = $this->userManager->getUserById($idUser);

        if ($user === false) {
            throw new Exception("Cet utilisateur n'existe pas.");
        }

        // Récupération de ses livres.
        $books = $this->bookManager->getBooksByUserId($idUser);

        $view = new View('Profil de ' . $user['username']);

        $view->render('profile', [
            'user' => $user,
            'books' => $books
        ]);
    }
}