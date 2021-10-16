<?php declare(strict_types=1);

class UserAuthentication
{
    public const LOGIN_INPUT_NAME = 'login';
    public const PASSWORD_INPUT_NAME = 'password';
    public const LOGOUT_INPUT_NAME = 'logout';
    public const SESSION_KEY = '__UserAuthentication__';
    public const SESSION_USER_KEY = 'user';

    private ?User $user = null;

    /**
     * Constructeur
     *
     * @throws SessionException si la session ne peut pas être démarrée
     */
    public function __construct()
    {
        try {
            // Restauration depuis la session si possible
            $this->user = $this->getUserFromSession();
        } catch (SessionException $exception) {
        }
    }

    /**
     * Production d'un formulaire de connexion
     * @param string $action URL cible du formulaire
     * @param string $submitText texte du bouton d'envoi
     *
     * @return string code HTML du formulaire
     */
    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $loginInputName = self::LOGIN_INPUT_NAME;
        $passwordInputName = self::PASSWORD_INPUT_NAME;
        // Le formulaire
        return <<<HTML
<form name='auth' action='{$action}' method='POST' autocomplete='off'>
  <div>
    <input type='text' name='{$loginInputName}' placeholder='login'>
    <input type='password' name='{$passwordInputName}' placeholder='pass' autocomplete='new-password'>
    <input type='submit'   value='{$submitText}'>
  </div>
</form>
HTML;
    }

    /**
     * Validation de la connexion de l'utilisateur
     *
     * @return User utilisateur authentifié
     *
     * @throws AuthenticationException si l'authentification échoue
     */
    public function getUserFromAuth(): User
    {
        if (!isset($_POST[self::LOGIN_INPUT_NAME]) || !isset($_POST[self::PASSWORD_INPUT_NAME])) {
            throw new AuthenticationException("pas de login/pass fournis");
        }

        try {
            // Préparation de la requête
            $stmt = MyPDO::getInstance()->prepare(<<<SQL
    SELECT id, firstName, lastName, login, phone
    FROM user
    WHERE login    = :login
    AND   sha512pass = SHA2(:password, 512)
SQL
            );
            $stmt->execute([
              ':login' => $_POST[self::LOGIN_INPUT_NAME],
              ':password' => $_POST[self::PASSWORD_INPUT_NAME]
            ]);

            // Test de réussite de la sélection
            if (($user_data = $stmt->fetch()) !== false) {
                $user = new User($user_data);
                $this->setUser($user);

                return $user;
            }
        } catch (PDOException $pdoException) {
            throw new AuthenticationException("Erreur base de données");
        } catch (SessionException $pdoException) {
            throw new AuthenticationException("Erreur de session");
        }

        throw new AuthenticationException("Login/pass incorrect");
    }

    protected function setUser(User $user): void
    {
        //Affecte l'utilisateur passé en paramètre à la propriété $user
		$this->user = $user;
		//Démarrage de la session
		Session::start();
		//Affecte la mémoire dans les données de session passé en paramètre à la propriété $user
		$user = new User($user_data);
    }

    /**
     * Test si un utilisateur est mémorisé dans les données de session
     * @return bool un utilisateur est connecté
     * @throws SessionException si la session ne peut pas être démarrée
     */
    public function isUserConnected(): bool
    {
		//Démarrage de la session
		Session::start();
        //Test si un utilisateur est mémorisé dans les données de session
        return isset($_SESSION[self::session_key]['connected']) ? $_SESSION[self::session_key]['connected'] : false;

    }

    /**
     * Formulaire de déconnexion de l'utilisateur
     * @param string $action URL cible du formulaire
     * @param string $buttonText texte du bouton de déconnexion
     * @return string le formulaire
     */
    public function logoutForm(string $action, string $buttonText): string
    {
        // Convertir tous les caractères spéciaux dans $buttonText
        $buttonText = htmlspecialchars($buttonText, ENT_QUOTES, 'utf-8');
        // Proposer le formulaire de déconnexion
        return <<<HTML
      <form method="POST" action="{$action}">
        <input type="submit" name="logout" value="{$buttonText}">
      </form>

HTML;
}

    }

    /**
     * Déconnecter l'utilisateur
     *
     * @return void
     * @throws SessionException si la session ne peut pas être démarrée
     */
    public function logoutIfRequested(): void
    {
        if (isset($_REQUEST[self::LOGOUT_INPUT_NAME])) {
           //Démarrage de la session
			Session::start();
			// Désactivation de la variable SESSION_KEY
            unset($_SESSION[self::session_key]);
			//Affecte l'utilisateur à null
            $user = null;
        }

        else {
            throw new SessionException();
        }

    }

    /**
     * Lecture de l'objet User dans la session
     *
     * @return User
     *
     * @throws SessionException si la session ne peut pas être démarrée
     * @throws NotLoggedInException si l'objet n'est pas dans la session
     */
    protected function getUserFromSession(): User
    {
        // Mise en place de la session
        if (User::isUserConnected()) {
            Session::start();
        // La variable de session existe ?
            if (isset($_SESSION[self::session_key]['user'])) {
            // Lecture de la variable de session
                var_dump $_SESSION['user'];
            // Est-ce un objet du bon type ?
                if (gettype($_SESSION[Session::session_key]["user"]) == "object")
                // insertion du user dans la fonctionnalité setUser
				    user->setUser();
                }
        }
        else {
        // NON ! exception SessionException
            throw new SessionException();
        }
        
    }

    /**
     * Accesseur à l'utilisateur connecté
     *
     * @return User utilisateur connecté
     * @throws NotLoggedInException Si aucun utilisateur n'est connecté
     */
    public function getUser(): User
    {
        // Si pas d'utilisateur trouvé
		if ()
			// exception SessionException "Aucun utilisateur connecté"
			throw new SessionException("Aucun utilisateur connecté");
		// Sinon retourne l'utilisateur
		else {
            return $_SESSION[Session::session_key]['user'];
        }
    }

}
