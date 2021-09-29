<<<<<<< HEAD
<?php
declare(strict_types=1);

require_once('autload.php');

// Création de l'authentification
$authentication = new UserAuthentification();
=======
<?php declare(strict_types=1);

require_once('autoload.php');

// Création de l'authentification
$authentication = new UserAuthentication();
>>>>>>> 06f734d7f84e6060314b9411a65c7d2025462af2

$p = new WebPage('Authentification');

// Production du formulaire de connexion
$p->appendCSS(<<<CSS
    form input {
        width : 4em ;
    }
CSS
);
$form = $authentication->loginForm('auth1.php');
$p->appendContent(<<<HTML
    {$form}
    <p>Pour faire un test : essai/toto
HTML
);

echo $p->toHTML();
