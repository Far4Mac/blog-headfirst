<?php
require_once ('../patterns/startsession.php');
require_once ('../vars/connectvars.php');

if (!isset($_SESSION['id'])){
    echo '<p>Пожалуйста, <a href="login.php">войдите</a> чтобы посмотреть профиль.';
    exit();
}

require_once ('../patterns/navmenu.php');

$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if (isset($_POST['submit'])){
    $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
    $text = mysqli_real_escape_string($dbc, trim($_POST['text']));
    $id = $_SESSION['id'];

    if (!empty($title) && !empty($text)){
        $query = "INSERT INTO notes (title, text, date, user_id) VALUES ('$title', '$text', NOW(), '$id')";
        mysqli_query($dbc, $query);

        echo '<p>Заметка добавлена. Вернуться <a href="viewprofile.php">назад</a> </p>';

        mysqli_close($dbc);
        exit();
    }
    else{
        echo '<p>Вы должны заполнить все поля</p>';
    }
}
mysqli_close($dbc);
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
        <legend>Новая заметка</legend>
        <label for="title">Заголовок:</label>
        <input type="text" name="title" value="<?php if (!empty($title)) echo $title; ?>"/><br/>
        <label for="text">Содержание:</label>
        <input type="text" name="text" value="<?php if (!empty($text)) echo $text; ?>"/>
    </fieldset>
    <input type="submit" value="Добавить" name="submit"/>
</form>
