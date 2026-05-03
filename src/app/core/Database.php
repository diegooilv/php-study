<?php
class Database
{
    private static $pdo;


    public static function connect()
    {
        if (!self::$pdo) {
            $config = require __DIR__ . "/../../config/database.php";
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            self::$pdo = new PDO($dsn, $config['user'], $config['pass']);
        }

        return self::$pdo;
    }
}