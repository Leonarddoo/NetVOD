<?php

namespace iutnc\netvod;

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\exception\InvalidPropertyNameException;

class User
{
    const ADMIN = 100;
    const STANDARD_USER = 1;

    private string $email;
    private string $passwd;
    private int $role;

    /**
     * @param string $email
     * @param string $passwd
     * @param int $role
     */
    public function __construct(string $email, string $passwd, int $role)
    {
        $this->email = $email;
        $this->passwd = $passwd;
        $this->role = $role;
    }

    public function __get(string $attr): mixed {
        if ($attr === 'id') return $this->id();
        if (property_exists($this, $attr)) return $this->$attr;
        throw new InvalidPropertyNameException("$attr isn't attribute of this instance of class");
    }

    private function id(): int
    {
        $PDO = ConnectionFactory::makeConnection();

        $statement = $PDO->prepare('SELECT id FROM User WHERE email = ?');
        $statement->bindParam(1, $this->email);
        $statement->execute();

        return $statement->fetch()['id'];
    }

    public static function sessionUser(): User{
        return unserialize($_SESSION['user']);
    }
}