<?php

// содержит переменные пагинации
include_once "config/core.php";

// для подключения к БД и файлы с объектами
include_once "config/database.php";
include_once "objects/doctor.php";
include_once "objects/category_doc.php";
include_once "objects/speciality_doc.php";

// создание экземпляра класса базы данных и товара
$database = new Database();
$db = $database->getConnection();

$doctor = new Doctor($db);
$category = new Category_doc($db);
$speciality = new Speciality_doc($db);

// получение поискового запроса
$search_term = isset($_GET["s"]) ? $_GET["s"] : "";

$page_title = "Вы искали \"{$search_term}\"";
require_once "layout_header.php";

// запрос врачей
$stmt = $doctor->search($search_term,$from_record_num, $records_per_page);

// указываем страницу, на которой используется пагинация
$page_url = "search.php?s={$search_term}&";

// подсчитываем общее количество строк - используется для разбивки на страницы
$total_rows = $doctor->countAll_BySearch($search_term);

// шаблон для отображения списка врачей
include_once "read_template.php";

// содержит наш JavaScript и закрывающие теги html
require_once "layout_footer.php";