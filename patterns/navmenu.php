<?php
echo '<hr />';
if(isset($_SESSION['name'])){
    echo '<a href="index.php">Главная</a>';
    echo '<a href="logout.php">Выйти (' . $_SESSION['name'] . ')</a>';
}
else{
    echo '<a href="login.php">Войти</a>';
    echo '<a href="signup.php">Зарегистрироваться</a>';
}
echo '<hr />';