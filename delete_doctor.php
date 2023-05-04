<?php

// проверим, было ли получено значение в $_POST
if ($_POST) {

    // подключаем файлы для работы с базой данных и файлы с объектами
    include_once "config/database.php";
    include_once "objects/doctor.php";

    // получаем соединение с базой данных
    $database = new Database();
    $db = $database->getConnection();

    // подготавливаем объект Doctor
    $doctor = new Doctor($db);

    // устанавливаем ID врача для удаления
    $doctor->id = $_POST["object_id"];

    // удаляем врача
    if ($doctor->delete()) {
        echo "Врач удалён";
    }

    // если невозможно удалить врача
    else {
        echo "Невозможно удалить врача";
    }
}
