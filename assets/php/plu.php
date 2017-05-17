<?php

if(!defined('KEY'))
{
    header("HTTP/1.1 404 Not Found");
    exit(file_get_contents('./../../404.php'));
}

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $res = $db_connect->query("SELECT * FROM `users` WHERE `login` = '$user'") or die($db_connect->error);
    $row = $res->fetch_assoc();
    $number = $row['click'];
}
else {
    echo showErrorMessage('Ошибка! Вы не авторизованы.');
}
//Если нажата кнопка то обрабатываем данные
if(isset($_POST['submit']))
{
    $click = $number + 1;
    $res = $db_connect->query("UPDATE `users` SET `click`= '$click' WHERE `login` = '$user'") or die($con->error);
    header('Location:'. HOST .'?mode=plu');
    exit;
}

if(isset($_POST['logout']))
{
    include './assets/php/logout.php';
}