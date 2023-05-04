<?php

// получаем ID редактируемого врача
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

// устанавливаем свойство ID товара для редактирования
$doctor->id = $id;

// получаем информацию о редактируемом товаре
$doctor->readOne();

// установка заголовка страницы
$page_title = "Обновление информации о враче";

include_once "layout_header.php";
?>

<!-- здесь будет контент -->
<div class="right-button-margin">
    <a href="index.php" class="btn btn-default pull-right">Просмотр всех врачей</a>
</div>

<!-- здесь будет форма обновления товара -->
<!-- здесь будет контент -->
<?php
// если форма была отправлена (submit)
if ($_POST) {

    // устанавливаем значения свойствам товара
    $doctor->fio = $_POST["fio"];
    $doctor->birth = $_POST["birth"];
    $doctor->category = $_POST["category_id"];
    $doctor->speciality = $_POST["speciality_id"];

    // обновление информации по врачу
    if ($doctor->update()) {
        echo "<div class='alert alert-success alert-dismissable'>";
        echo "Информация о враче  обновлёна.";
        echo "</div>";
    }

    // если не удается обновить, сообщим об этом пользователю
    else {
        echo "<div class='alert alert-danger alert-dismissable'>";
        echo "Невозможно обновить информацию.";
        echo "</div>";
    }
}
?>
<!-- HTML-формы для создания врача -->
<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
    <table class="table table-hover table-responsive table-bordered">
  
        <tr>
            <td>Фамилия, имя, отчество</td>
            <td><input type="text"  value="<?= $doctor->fio; ?>" name="fio" class="form-control" /></td>
        </tr>
  
        <tr>
            <td>Дата рождения</td>
            <td><input type="date" value="<?= $doctor->birth; ?>" name="birth" class="form-control" /></td>
        </tr>
        <tr>
            <td>Специализация</td>
            <td>
            <?php
// читаем категории из базы данных
$stmt = $speciality->read();

// помещаем их в выпадающий список
echo "<select class='form-control' name='speciality_id'>";
echo "<option>Выбрать специальность...</option>";

while ($row_speciality = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $speciality_id = $row_speciality["id"];
  $speciality_name = $row_speciality["speciality"];
// необходимо выбрать текущую специальность врача
if ($doctor->speciality == $speciality_id) {
  echo "<option value='$speciality_id' selected>";
} else {
  echo "<option value='$speciality_id'>";
}
echo "$speciality_name</option>";

}

echo "</select>";
?>
            </td>
        </tr>
  
        <tr>
            <td>Категория</td>
            <td>
              <?php
// читаем категории из базы данных
$stmt = $category->read();

// помещаем их в выпадающий список
echo "<select class='form-control' name='category_id'>";
echo "<option>Выбрать категорию...</option>";

while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $category_id = $row_category["id"];
  $category_name = $row_category["category"];
// необходимо выбрать текущую категорию врача
if ($doctor->category == $category_id) {
  echo "<option value='$category_id' selected>";
} else {
  echo "<option value='$category_id'>";
}
echo "$category_name</option>";

}

echo "</select>";
?>
            </td>
        </tr>
  
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Внести</button>
            </td>
        </tr>
  
    </table>
</form>

<?php // подвал
require_once "layout_footer.php";