<?php

class Database
{
    // учетные данные базы данных
    private $host = "127.0.0.1";
    private $db_name = "request_db";
    private $username = "root";
    private $password = "";
    public $conn;

    // получаем соединение с БД
    public function getConnection()
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Ошибка подключения: " . $exception->getMessage();
        }

        return $this->conn;
    }
}