<?php

class Speciality_doc
{
    // подключение к базе данных и имя таблицы
    private $conn;
    private $table_name = "speciality";

    // свойства объекта
    public $id;
    public $speciality;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // данный метод используется в раскрывающемся списке
    function read()
    {
        // запрос MySQL: выбираем столбцы в таблице 
        $query = "SELECT
                    id, speciality
                FROM
                    " . $this->table_name . "
                ORDER BY
                speciality";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    // получение названия категории по её ID
function readSpeciality()
{
    // запрос MySQL
    $query = "SELECT speciality FROM " . $this->table_name . " WHERE id = ? limit 0,1";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->speciality = $row["speciality"];
}


}