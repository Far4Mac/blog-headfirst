<?php
session_start();
if (isset($_SESSION['id'])){
    // clear session vars
    $_SESSION = array();

    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(), '', time() - 3600);
    }

    session_destroy();
}

setcookie('id', '', time() - 3600);
setcookie('name', '', time() - 3600);

$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
header('Location: ' . $home_url);