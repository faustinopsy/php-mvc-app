<?php

namespace App\Config;

use PDO;
use PDOException;
use Exception;

class Database
{
    private static $instance = null;

    private function __construct()
    {
        // Impede a criação de instâncias externas
    }

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            try {
                $connection = $_ENV['DB_CONNECTION'] ?? 'sqlite';

                if ($connection === 'mysql') {
                    $dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']}";
                    self::$instance = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
                } elseif ($connection === 'sqlite') {
                    $dsn = "sqlite:" . __DIR__ . '/../' . ($_ENV['DB_DATABASE'] ?? 'database.sqlite');
                    self::$instance = new PDO($dsn);
                } else {
                    throw new Exception("Unsupported database connection: $connection");
                }

                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Could not connect to the database: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}