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
        // ===========================
        // AFFICHAGE DU FORMULAIRE
        // ===========================

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            $view = new View('Inscription');
            $view->render('register');

            return;
        }

        // ===========================
        // RÉCUPÉRATION DES DONNÉES
        // ===========================

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // ===========================
        // VALIDATION PSEUDO
        // ===========================

        if ($username === '') {

            $this->showRegisterError(
                'Le pseudo est obligatoire.',
                $username,
                $email
            );

            return;
        }

        // ===========================
        // VALIDATION EMAIL
        // ===========================

        if ($email === '') {

            $this->showRegisterError(
                "L'adresse email est obligatoire.",
                $username,
                $email
            );

            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $this->showRegisterError(
                "L'adresse email n'est pas valide.",
                $username,
                $email
            );

            return;
        }

        // ===========================
        // VALIDATION MOT DE PASSE
        // ===========================

        if ($password === '') {

            $this->showRegisterError(
                'Le mot de passe est obligatoire.',
                $username,
                $email
            );

            return;
        }

        if (strlen($password) < 8) {

            $this->showRegisterError(
                'Le mot de passe doit contenir au moins 8 caractères.',
                $username,
                $email
            );

            return;
        }

        // ===========================
        // PSEUDO DÉJÀ UTILISÉ
        // ===========================

        if ($this->userManager->usernameExists($username)) {

            $this->showRegisterError(
                'Ce pseudo est déjà utilisé.',
                $username,
                $email
            );

            return;
        }

        // ===========================
        // EMAIL DÉJÀ UTILISÉ
        // ===========================

        if ($this->userManager->emailExists($email)) {

            $this->showRegisterError(
                'Cette adresse email est déjà utilisée.',
                $username,
                $email
            );

            return;
        }

        // ===========================
        // HASH DU MOT DE PASSE
        // ===========================

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        // ===========================
        // CRÉATION UTILISATEUR
        // ===========================

        $success = $this->userManager->createUser(
            $username,
            $email,
            $hashedPassword
        );

        if (!$success) {

            $this->showRegisterError(
                "Une erreur est survenue pendant l'inscription.",
                $username,
                $email
            );

            return;
        }

        // ===========================
        // REDIRECTION
        // ===========================
        header('Location: index.php?action=login');
        exit;
    }

    /**
     * Affiche et traite le formulaire de connexion.
     */
    public function login(): void
    {
        // ===========================
        // AFFICHAGE DU FORMULAIRE
        // ===========================

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            $view = new View('Connexion');
            $view->render('login');

            return;
        }

        // ===========================
        // RÉCUPÉRATION DES DONNÉES
        // ===========================

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // ===========================
        // VALIDATION EMAIL
        // ===========================

        if ($email === '') {

            $this->showLoginError(
                "L'adresse email est obligatoire.",
                $email
            );

            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $this->showLoginError(
                "L'adresse email n'est pas valide.",
                $email
            );

            return;
        }

        // ===========================
        // VALIDATION MOT DE PASSE
        // ===========================

        if ($password === '') {

            $this->showLoginError(
                'Le mot de passe est obligatoire.',
                $email
            );

            return;
        }

        // ===========================
        // RECHERCHE UTILISATEUR
        // ===========================

        $user = $this->userManager->getUserByEmail($email);


        if ($user === false) {

            $this->showLoginError(
                'Adresse email ou mot de passe incorrect.',
                $email
            );

            return;
        }

        // ===========================
        // VÉRIFICATION MOT DE PASSE
        // ===========================

        if (!password_verify($password, $user['password'])) {

            $this->showLoginError(
                'Adresse email ou mot de passe incorrect.',
                $email
            );

            return;
        }

        // ===========================
        // CONNEXION
        // ===========================

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id_user' => $user['id_user'],
            'username' => $user['username'],
            'email' => $user['email'],
            'avatar' => $user['avatar']
        ];


        // ===========================
        // REDIRECTION
        // ===========================

        header('Location: index.php?action=home');
        exit;
    }

    /**
     * Réaffiche le formulaire d'inscription
     * avec un message d'erreur.
     */
    private function showRegisterError(
        string $message,
        string $username = '',
        string $email = ''
    ): void {

        $view = new View('Inscription');

        $view->render('register', [
            'errorMessage' => $message,
            'username' => $username,
            'email' => $email
        ]);
    }

    /**
     * Affiche une erreur de connexion.
     */
    /**
     * Affiche une erreur de connexion.
     */
    private function showLoginError(
        string $message,
        string $email = ''
    ): void {

        $view = new View('Connexion');

        $view->render('login', [
            'errorMessage' => $message,
            'email' => $email
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

        // ===========================
        // CHAMPS OBLIGATOIRES
        // ===========================

        if ($username === '') {

            $this->renderAccount(
                $idUser,
                'Le pseudo est obligatoire.'
            );

            return;
        }

        if ($email === '') {

            $this->renderAccount(
                $idUser,
                "L'adresse email est obligatoire."
            );

            return;
        }

        // ===========================
        // EMAIL
        // ===========================

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $this->renderAccount(
                $idUser,
                "L'adresse email n'est pas valide."
            );

            return;
        }

        // ===========================
        // PSEUDO DÉJÀ UTILISÉ
        // ===========================

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

        // ===========================
        // EMAIL DÉJÀ UTILISÉ
        // ===========================

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

        // ===========================
        // MOT DE PASSE
        // ===========================

        $hashedPassword = null;

        // Le mot de passe est facultatif.
        // S'il est vide, l'ancien est conservé.
        if ($password !== '') {

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

        // ===========================
        // MISE À JOUR
        // ===========================

        $this->userManager->updateUser(
            $idUser,
            $username,
            $email,
            $hashedPassword
        );

        // Mise à jour de la session.
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