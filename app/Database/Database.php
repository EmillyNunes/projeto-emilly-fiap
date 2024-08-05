<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private static $pdo = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO('mysql:host=db;dbname=db_fiap', 'emilly', 'emilly@123');
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                exit;
            }
        }
        return self::$pdo;
    }
}
