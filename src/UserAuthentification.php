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

<<<<<<< HEAD
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
=======
    public function getUserFromAuth(array $data)
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM user
            WHERE login=:login AND sha512pass=SHA2(:pass, 512)
        SQL
        );

        $stmt->execute(array(":login" => $data["login"], ":pass" => $data["pass"]));

        if ($stmt->rowCount() == 0)
            throw new AuthenticationException();

        $stmt->setFetchMode(PDO::FETCH_ASSOC, "User");
        return $stmt->fetch();
>>>>>>> b4022815b9d0ae5e6a65dd5e18ed3572ae9d95dc

    }

}
