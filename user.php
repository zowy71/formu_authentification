<?php declare(strict_types=1);

class User {
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $firstName;
    /**
     * @var string
     */
    private string $lastName;
    /**
     * @var string
     */
    private string $login;
    /**
     * @var int
     */
    private int $phone;

    public function __construct($data) {
        $this->id = isset($data['id']) ? 'id' : 0;
        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
        $this->login = $data['login'];
        $this->phone = $data['phone'];
    }

    public function profile(): string
    {
        return <<<HTML
      <p>
        Firstname : {$this->firstName}<br>
        Lastname : {$this->lastName}<br>
        Login : {$this->login} - {$this->id}<br>
        Phone number : {$this->phone}
      </p>
    HTML;
    }
}
