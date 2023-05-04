<?php
// страница, указанная в параметре URL, страница по умолчанию - 1
$page = isset($_GET["page"]) ? $_GET["page"] : 1;

// устанавливаем ограничение количества записей на странице
$records_per_page = 5;

// подсчитываем лимит запроса
$from_record_num = ($records_per_page * $page) - $records_per_page;

// здесь будет получение товаров из БД
// включаем соединение с БД и файлы с объектами
include_once "config/database.php";
include_once "objects/doctor.php";
include_once "objects/category_doc.php";
include_once "objects/speciality_doc.php";

// создаём экземпляры классов БД и объектов
$database = new Database();
$db = $database->getConnection();

$doctor = new Doctor($db);
$category_doc = new Category_doc($db);
$speciality_doc = new Speciality_doc($db);

// запрос товаров
$stmt = $doctor->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();
// установка заголовка страницы
$page_title = "Врачи";

require_once "layout_header.php";
?>
<div class="right-button-margin">
    <a href="create_doctor.php" class="btn btn-default pull-right">Добавить врача</a>
</div>
<?php
// отображаем товары, если они есть
if ($num > 0) {

    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Врач</th>";
            echo "<th>Дата рождения</th>";
            echo "<th>Специальность</th>";
            echo "<th>Категория</th>";
        echo "</tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);

            echo "<tr>";
                echo "<td>{$fio}</td>";
                echo "<td>{$birth}</td>";
                echo "<td>";
                    $speciality_doc->id = $speciality;
                    $speciality_doc->readSpeciality();
                    echo $speciality_doc->speciality;
                echo "</td>";
                // echo "<td>{$speciality}</td>";
                echo "<td>";
                    $category_doc->id = $category;
                    $category_doc->readCategory();
                    echo $category_doc->category;
                echo "</td>";
  
                echo "<td>";
                    // здесь будут кнопки для просмотра, редактирования и удаления
                    // ссылки/кнопки для просмотра, редактирования и удаления товара
          echo "<a href='read_doctor.php?id={$id}' class='btn btn-primary left-margin'>
          <span class='glyphicon glyphicon-list'></span> Просмотр
          </a>

          <a href='update_doctor.php?id={$id}' class='btn btn-info left-margin'>
          <span class='glyphicon glyphicon-edit'></span> Редактировать
          </a>

          <a delete-id='{$id}' class='btn btn-danger delete-object'>
          <span class='glyphicon glyphicon-remove'></span> Удалить
          </a>";
                echo "</td>";

            echo "</tr>";

        }

    echo "</table>";

    // здесь будет пагинация
    // страница, на которой используется пагинация
$page_url = "index.php?";

// подсчёт всех товаров в базе данных, чтобы подсчитать общее количество страниц
$total_rows = $doctor->countAll();

// пагинация
include_once "paging.php";
}

// сообщим пользователю, что врачей нет
else {
    echo "<div class='alert alert-info'>Врачи не найдены.</div>";
}
?>
<?php // подвал
require_once "layout_footer.php";