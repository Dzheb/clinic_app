<?php
// подключим файлы, необходимые для подключения к базе данных и файлы с объектами
include_once "config/database.php";
include_once "objects/doctor.php";
include_once "objects/category_doc.php";
include_once "objects/speciality_doc.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// создадим экземпляры классов Doctor и Category_doc
$doctor = new Doctor($db);
$category_doc = new Category_doc($db);
$speciality_doc = new Speciality_doc($db);
// установка заголовка страницы
$page_title = "Новый врач";

require_once "layout_header.php";
?>
<div class="right-button-margin">
    <a href="index.php" class="btn btn-default pull-right">Просмотр всех врачей</a>
</div>


<?php
// если форма была отправлена
if ($_POST) 
{
    // установим значения реквизитов врача
    $doctor->fio = $_POST["fio"];
    $doctor->birth = $_POST["birth"];
    $doctor->category = $_POST["category_id"];
    $doctor->speciality = $_POST["speciality_id"];

    // создание врача
    if ($doctor->create()) {
        echo '<div class="alert alert-success">Новый врач успешно внесён.</div>';
    }

    // если не удается создать врача, сообщим об этом 
    else {
        echo '<div class="alert alert-danger">Невозможно внести врача.</div>';
    }
}
?>

<!-- HTML-формы для создания врача -->
<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
  
    <table class="table table-hover table-responsive table-bordered">
  
        <tr>
            <td>Фамилия, имя, отчество</td>
            <td><input type="text" name="fio" class="form-control" /></td>
        </tr>
  
        <tr>
            <td>Дата рождения</td>
            <td><input type="date" name="birth" class="form-control" /></td>
        </tr>
        <tr>
            <td>Специализация</td>
            <td>
              <?php
// читаем категории из базы данных
$stmt = $speciality_doc->read();

// помещаем их в выпадающий список
echo "<select class='form-control' name='speciality_id'>";
echo "<option>Выбрать специальность...</option>";

while ($row_speciality = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row_speciality);
    echo "<option value='{$id}'>{$speciality}</option>";
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
$stmt = $category_doc->read();

// помещаем их в выпадающий список
echo "<select class='form-control' name='category_id'>";
echo "<option>Выбрать категорию...</option>";

while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row_category);
    echo "<option value='{$id}'>{$category}</option>";
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
?>