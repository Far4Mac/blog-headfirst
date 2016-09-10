<?php
require_once ('../patterns/startsession.php');
require_once ('../vars/connectvars.php');

if (!isset($_SESSION['id'])){
    echo '<p>Пожалуйста, <a href="login.php">войдите</a> чтобы посмотреть профиль.';
    exit();
}

require_once ('../patterns/navmenu.php');

$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if(!isset($_GET['id'])){
    $query = "SELECT title, text, date FROM notes WHERE user_id = '" . $_SESSION['id'] . "'";
}
else{
    $query = "SELECT title, text, date FROM notes WHERE user_id = '" . $_GET['id'] . "'";
}
$data = mysqli_query($dbc, $query);

echo '<table>';
while ($row = mysqli_fetch_array($data)){
    echo '<td>' . $row['title'] . '</td><td>' . $row['text'] . '</td><td>' . $row['date'] . '</td></tr>';
}
echo '</table>';
if (!isset($_GET['id']) || ($_SESSION['id']) == $_GET['id']){
    echo '<p>Вы можете <a href="editprofile.php">добавить заметки</a></p>';
}

mysqli_close($dbc);