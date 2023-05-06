<?php

// содержит переменные пагинации
include_once "config/core.php";

// файлы для работы с БД и файлы с объектами
include_once "config/database.php";
include_once "objects/doctor.php";
include_once "objects/category_doc.php";
include_once "objects/speciality_doc.php";

// получение соединения с БД
$database = new Database();
$db = $database->getConnection();
$doctor = new Doctor($db);
$category_doc = new Category_doc($db);
$speciality_doc = new Speciality_doc($db);


$page_title = "Врачи";

include_once "layout_header.php";

// получение товаров
$stmt = $doctor->readAll($from_record_num, $records_per_page);

// укажем страницу, на которой используется пагинация
$page_url = "index.php?";

// подсчёт общего количества строк (используется для разбивки на страницы)
$total_rows = $doctor->countAll();

// контролирует, как будет отображаться список 
include_once "read_template.php";

// содержит наш JavaScript и закрывающие теги html
include_once "layout_footer.php";