<?php

namespace iutnc\netvod\db;

use PDO;

class ConnectionFactory
{
    private static array $config_file;

    public static function setConfig($file): void
    {
        static::$config_file = parse_ini_file($file);
    }

    public static function makeConnection(): PDO
    {
        $config = static::$config_file;
        return new PDO("{$config['driver']}:host={$config['host']};dbname={$config['database']};charset=utf8", $config['username'], $config['password']);
    }

}