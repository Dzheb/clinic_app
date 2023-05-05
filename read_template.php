<?php
$category_doc = new Category_doc($db);
$speciality_doc = new Speciality_doc($db);

// форма поиска
echo "<form role='search' action='search.php'>";
echo "<div class='input-group col-md-3 pull-left margin-right-1em'>";
$search_value = isset($search_term) ? "value='{$search_term}'" : "";
echo "<input type='text' class='form-control' placeholder='Ф.И.О. врача  ...' name='s' required {$search_value} />";
echo "<div class='input-group-btn'>";
echo "<button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i></button>";
echo "</div>";
echo "</div>";
echo "</form>";

// кнопка просмотра врачей
echo "<div class='right-button-margin'>";
echo "<a href='index.php' class='btn btn-primary pull-right'>";
echo "<span class='glyphicon glyphicon-plus'></span>Просмотр  врачей";
echo "</a>";
echo "</div>";

// показать врачей, если они есть
if ($total_rows > 0) {
  
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
          echo "<td>";
              $category_doc->id = $category;
              $category_doc->readCategory();
              echo $category_doc->category;
          echo "</td>";

          echo "<td>";
              // ссылки/кнопки для просмотра, редактирования и удаления
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

// страница, на которой используется пагинация
$page_url = "index.php?";

// подсчёт всех записей в базе данных, чтобы подсчитать общее количество страниц
$total_rows = $doctor->countAll();

// пагинация
include_once "paging.php";
// 
    
    // пагинация
    include_once "paging.php";
}
// сообщим пользователю, что врачей нет
else {
  echo "<div class='alert alert-info'>Врачи не найдены.</div>";
}