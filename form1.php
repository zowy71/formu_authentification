<?php
declare(strict_types=1);

require_once('autload.php');
require_once('MyPD0.php');

$authentication = new UserAuthentication();

$p = new WebPage('Authentification');

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
