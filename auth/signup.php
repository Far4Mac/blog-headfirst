<?php
require_once ('../vars/connectvars.php');

$dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
    $pass1 = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
    $pass2 = mysqli_real_escape_string($dbc, trim($_POST['pass2']));

    if(!empty($name) && !empty($pass1) && !empty($pass2) && ($pass1 == $pass2)){
        $query = "SELECT * FROM users WHERE name = '$name'";
        $data = mysqli_query($dbc, $query);
        if(mysqli_num_rows($data) == 0){
            $query = "INSERT INTO users (name, password) VALUES ('$name', SHA('$pass1'))";
            mysqli_query($dbc, $query);

            echo '<p>Аккаунт создан. Вы можете <a href="login.php">войти</a>.</p>';

            mysqli_close($dbc);
            exit();
        }
        else{
            echo '<p>Аккаунт уже существует. Используйте другое имя.</p>';
            $name = "";
        }
    }
    else{
        echo '<p>Вы должны заполнить все поля.</p>';
    }
}
mysqli_close($dbc);
?>

<p>Заполните все поля чтобы зарегистрироваться.</p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
        <legend>Данные</legend>
        <label for="name">Имя пользователя:</label>
        <input type="text" id="name" name="name" value="<?php if (!empty($name)) echo $name; ?>" /><br />
        <label for="pass1">Пароль:</label>
        <input type="password" id="pass1" name="pass1" /><br />
        <label for="pass2">Повторите пароль:</label>
        <input type="password" id="pass2" name="pass2" /><br />
    </fieldset>
    <input type="submit" value="Зарегистрироваться" name="submit" />
</form>
