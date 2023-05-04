<?php

class Doctor
{
    // подключение к базе данных и имя таблицы
    private $conn;
    private $table_name = "doctors";

    // свойства объекта
    
    public $id;
    public $fio;
    public $category;
    public $speciality;
    public $birth;
    

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // метод создания товара
    function create()
    {
        // запрос MySQL для вставки записей в таблицу БД «products»
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    fio=:fio, category=:category, speciality=:speciality, birth=:birth";

        $stmt = $this->conn->prepare($query);

        // опубликованные значения
        $this->fio = htmlspecialchars(strip_tags($this->fio));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->speciality = htmlspecialchars(strip_tags($this->speciality));
        $this->birth = htmlspecialchars(strip_tags($this->birth));

        // привязываем значения
        $stmt->bindParam(":fio", $this->fio);
        $stmt->bindParam(":birth", $this->birth);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":speciality", $this->speciality);

        if ($stmt->execute()) {
            return true;
        } else {
            return  false;
        }
    }
    // метод для получения товаров
function readAll($from_record_num, $records_per_page)
{
    // запрос MySQL
    $query = "SELECT
                id, fio, birth, category, speciality
            FROM
                " . $this->table_name . "
            ORDER BY
                fio ASC
            LIMIT
                {$from_record_num}, {$records_per_page}";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
}
// используется для пагинации товаров
public function countAll()
{
    // запрос MySQL
    $query = "SELECT id FROM " . $this->table_name . "";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    $num = $stmt->rowCount();

    return $num;
}
// метод для получения товара
function readOne()
{
    // запрос MySQL
    $query = "SELECT
                fio, birth, category, speciality
            FROM
                " . $this->table_name . "
            WHERE
                id = ?
            LIMIT
                0,1";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->fio = $row["fio"];
    $this->birth = $row["birth"];
    $this->category = $row["category"];
    $this->speciality = $row["speciality"];
}
// метод для обновления товара
function update()
{
    // MySQL запрос для обновления записи (товара)
    $query = "UPDATE
                " . $this->table_name . "
            SET
                fio = :fio,
                birth = :birth,
                category  = :category,
                speciality = :speciality
            WHERE
                id = :id";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    // очистка
    $this->fio = htmlspecialchars(strip_tags($this->fio));
    $this->birth = htmlspecialchars(strip_tags($this->birth));
    $this->category = htmlspecialchars(strip_tags($this->category));
    $this->speciality = htmlspecialchars(strip_tags($this->speciality));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // привязка значений
    $stmt->bindParam(":fio", $this->fio);
    $stmt->bindParam(":birth", $this->birth);
    $stmt->bindParam(":category", $this->category);
    $stmt->bindParam(":speciality", $this->speciality);
    $stmt->bindParam(":id", $this->id);

    // выполняем запрос
    if ($stmt->execute()) {
        return true;
    }

    return false;
}
// метод для удаления товара
function delete()
{
    // запрос MySQL для удаления
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);

    if ($result = $stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
}