<?php

class Proposal
{
    // подключение к базе данных и таблице "request"
    public $conn;
    private $table_name = "request";

    // свойства объекта
    public $id;
    public $user_name;
    public $email;
    public $phone;
    public $textarea;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // метод для создания данных записи
    function create($user_name, $email, $phone, $textarea)
    {
        // запрос для вставки (создания) записи
        $query = "INSERT INTO " . $this->table_name . " (user_name, email, phone, textarea) VALUES (?, ?, ?, ?)";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // привязка значений
        $stmt->bindParam("1", $user_name);
        $stmt->bindParam("2", $email);
        $stmt->bindParam("3", $phone);
        $stmt->bindParam("4", $textarea);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}