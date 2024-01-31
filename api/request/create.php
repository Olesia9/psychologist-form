<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// получаем соединение с базой данных
include_once "../config/database.php";
include_once "../config/methods.php";

// создание объекта записи
$database = new Database();
$db = $database->getConnection();
$product = new Proposal($db);

// Получение данных из тела запроса
$data = json_decode(file_get_contents("php://input"));
echo json_encode($data, JSON_UNESCAPED_UNICODE);

// убеждаемся, что данные не пусты
if (
    !empty($data->user_name) &&
    !empty($data->email) &&
    !empty($data->phone) &&
    (!empty($data->textarea) || empty($data->textarea))
) {
    // устанавливаем значения свойств записи
    $product->user_name = $data->user_name;
    $product->email = $data->email;
    $product->phone = $data->phone;
    $product->textarea = $data->textarea;

    // создание самой записи
    if ($product->create($data->user_name, $data->email, $data->phone, $data->textarea)) {
        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Запись создана."), JSON_UNESCAPED_UNICODE);
    } // если не удается создать запись, сообщим пользователю
    else {
        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("message" => "Невозможно создать запись."), JSON_UNESCAPED_UNICODE);
    }

} else {
    // установим код ответа - 400 неверный запрос
    http_response_code(400);
    echo json_encode(array("message" => "Невозможно добавить запись. Данные неполные."), JSON_UNESCAPED_UNICODE);
}
?>