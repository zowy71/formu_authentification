<?php declare(strict_types=1);

class UserAuthentification {

    public const LOGIN_INPUT_NAME = 'login';
    public const PASSWORD_INPUT_NAME = 'password';

    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $login = self::LOGIN_INPUT_NAME;
        $password = self::PASSWORD_INPUT_NAME;

        return <<<HTML
            <form method="post" action="{$action}">
                <input type="text" name="{$login}">
                <input type="password" name="{$password}">
                <button type="submit">{$submitText}</button>
            </form>
HTML;
    }

    public function getUserFromAuth(array $data): string
    {
        $rqt = MyPDO::getInstance()->prepare(
            <<<SQL
    select *
    from user
    where login=:login and SHA2(CONCAT(sha2pass,:challenge,SHA2(login)))=:code
SQL );
        $rqt->setFetchMode(PDO::FETCH_ASSOC);
        $rqt->execute(array("login" => $data['login'], "password" => $data['password']));
        return $rqt->fetch();

    }

}
