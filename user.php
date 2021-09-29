<?php
declare(strict_types=1);

require_once('autload.php');

echo <<<HTML
<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Test rapide de la classe User</title>
    </head>
    <body>

HTML;

$user1 = new User([
    'id' => '1',
    'firstName' => 'Marcel',
    'lastName' => 'Essai',
    'login' => 'essai',
    'phone' => '123456789',
]);
echo "<pre>\n";
var_dump($user1);
echo "</pre>\n";

echo $user1->profile();

$user2 = new User([
    'id' => '2',
    'firstName' => 'BoB',
    'lastName' => '',
    'login' => 'bob'
]);
echo "<pre>\n";
var_dump($user2);
echo "</pre>\n";

echo <<<HTML
    {$user2->profile()}
    </body>
</html>
HTML;
