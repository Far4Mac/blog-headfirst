<?php
require_once ('../vars/connectvars.php');

session_start();

$error_msg = "";

if(!isset($_SESSION['id'])){
    if(isset($_POST['submit'])){
        $dbc = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

        $username = mysqli_real_escape_string($dbc, trim($_POST['name']));
        $password = mysqli_real_escape_string($dbc, trim($_POST['pass']));

        if(!empty($username) && !empty($password)){
            $query = "SELECT id, name FROM users WHERE name = '$username' AND password = SHA('$password')";
            $data = mysqli_query($dbc, $query);

            if(mysqli_num_rows($data) == 1){
                $row = mysqli_fetch_array($data);
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                setcookie('id', $row['id'], time() + (60 * 60 * 24 * 30));
                setcookie('name', $row['name'], time() + (60 * 60 * 24 * 30));
                $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
                header('Location: ' . $home_url);
            }
            else {
                $error_msg = 'Вы должны ввести верные имя и пароль.';
            }
        }
        else {
            $error_msg = 'Вы должны ввести логин и пароль.';
        }
    }
}

if (empty($_SESSION['id'])) {
    echo '<p>' . $error_msg . '</p>';
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
            <legend>Вход</legend>
            <label for="name">Имя пользователя:</label>
            <input type="text" name="name" value="<?php if (!empty($username)) echo $username; ?>"/><br/>
            <label for="pass">Пароль:</label>
            <input type="password" name="pass"/>
        </fieldset>
        <input type="submit" value="Вход" name="submit"/>
    </form>

    <?php
}
else{
    echo ('<p>Вы вошли как ' . $_SESSION['name'] . '</p>');
}
