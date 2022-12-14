<?php

namespace iutnc\netvod\auth;

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\exception\AuthException;
use iutnc\netvod\User;

class Auth
{
    public static function authenticate(string $email, string $passwd): User
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $PDO = ConnectionFactory::makeConnection();
            $statement = $PDO->prepare('SELECT * FROM User WHERE email = ?');

            $statement->bindParam(1, $email);

            $statement->execute();

            $data = $statement->fetch();
            if ($data) {
                $hash = $data['passwd'];
                if (password_verify($passwd, $hash)) {
                    $user = new User($email, $hash, $data['role']);
                    self::loadProfile($user);
                    return $user;
                }
            }
        }
        throw new AuthException();
    }

    public static function loadProfile(User $user): void
    {
        $_SESSION['user'] = serialize($user);
    }

    public static function register(string $email, string $passwd): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $length = strlen($passwd) >= 10;

            $PDO = ConnectionFactory::makeConnection();
            $statement = $PDO->prepare('SELECT count(email) FROM User WHERE email = ?');

            $statement->bindParam(1, $email);

            $statement->execute();

            $alreadyEmail = $statement->fetch()[0] === 0;

            if ($length and $alreadyEmail) {
                $hash = password_hash($passwd, PASSWORD_DEFAULT, ['cost' => 12]);

                $statement = $PDO->prepare('INSERT INTO User(email, passwd, role) VALUES (?, ?, 1)');

                $statement->bindParam(1, $email);
                $statement->bindParam(2, $hash);

                return $statement->execute();
            }
        }
        return false;
    }

    public static function connected(): bool
    {
        return isset($_SESSION['user']);
    }


}