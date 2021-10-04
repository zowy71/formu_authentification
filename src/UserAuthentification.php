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

    }

}
