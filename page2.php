<?php

require_once('autload.php');
require_once('src/MYPD0.php');


if (User::isConnected()) {
  $user = User::createFromSession();

  $p = new WebPage('PAGE 2');

  $p->appendContent(
    <<<HTML
    <h1>Page n°2</h1>

    {$user->profile()}
    <p> <a href="page1.php">Page 1</a> </p>
HTML
  );

  echo $p->toHTML();
}
else {
  header("Location: form3.php");
}
