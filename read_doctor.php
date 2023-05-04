<?php
// получаем ID доктора
$id = isset($_GET["id"]) ? $_GET["id"] : die("ERROR: отсутствует ID.");

// подключаем файлы для работы с базой данных и файлы с объектами
include_once "config/database.php";
include_once "objects/doctor.php";
include_once "objects/category_doc.php";
include_once "objects/speciality_doc.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();
 
// подготавливаем объекты
$doctor = new Doctor($db);
$category = new Category_doc($db);
$speciality = new Speciality_doc($db);

// устанавливаем свойство ID врача для чтения
$doctor->id = $id;

// получаем информацию о враче
$doctor->readOne();
// установка заголовка страницы
$page_title = "Страница врачей (чтение одного врача)";

require_once "layout_header.php";
?>

<!-- ссылка на всех врачей -->
<div class="right-button-margin">
    <a href="index.php" class="btn btn-primary pull-right">
        <span class="glyphicon glyphicon-list"></span> Просмотр всех врачей
    </a>
</div>
<!-- HTML-таблица для отображения информации о враче -->
<table class="table table-hover table-responsive table-bordered">
    <tr>
        <td>Фамилия, имя, отчество</td>
        <td><?= $doctor->fio; ?></td>
    </tr>
    <tr>
        <td>Дата рождения</td>
        <td><?= $doctor->birth; ?></td>
    </tr>
    <tr>
        <td>Специализация</td>
        <td>
        <?php // выводим название специальности
            $speciality->id = $doctor->speciality;
            $speciality->readSpeciality();
            echo $speciality->speciality;
            ?>
        </td>
    </tr>
    <tr>
        <td>Категория</td>
        <td>
            <?php // выводим название категории
            $category->id = $doctor->category;
            $category->readCategory();

            echo $category->category;
            ?>
        </td>
    </tr>
</table>
<?php // подвал
require_once "layout_footer.php";