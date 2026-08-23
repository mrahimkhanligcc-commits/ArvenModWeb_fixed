<?php

class Database
{
    private string $host = 'localhost';
    private string $db = 'arven';
    private string $user = 'root';
    private string $pass = '';
    private string $charset = 'utf8mb4';

    public PDO $pdo;

    public function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            http_response_code(500);
            die('Database connection failed. Check your database settings.');
        }
    }
}
