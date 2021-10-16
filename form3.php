<?php
require_once('autload.php');
require_once('src/MyPD0.php');

$p = new WebPage('Authentification');

// Production du formulaire de connexion
$p->appendCSS(
  <<<CSS
    form input {
        width : 4em ;
    }
CSS
);

if (User::isConnected()) {
  $user = User::createFromSession();

  $form = User::logoutForm('src/UserAuthentication.php');
  $p->appendContent(
    <<<HTML
    {$user->profile()}
    {$form}
HTML
  );
}
else {
  $form = User::loginForm('auth3.php');
  $p->appendContent(
    <<<HTML
    {$form}
HTML
  );
}

echo $p->toHTML();