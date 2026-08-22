<?php

namespace App;

class Connection
{
    public static function getDb()
    {
        try {
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $database = $_ENV['DB_DATABASE'] ?? 'exitus';

            $conn = new \PDO(
                "mysql:host={$host};dbname={$database};charset=utf8",
                $_ENV['DB_USERNAME'] ?? 'root',
                $_ENV['DB_PASSWORD'] ?? ''
            );

            return $conn;
            
        } catch (\PDOException $e) {
            echo ($e->getMessage());
        }
    }
}