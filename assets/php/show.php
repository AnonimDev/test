<?php

//Ключ защиты
if(!defined('KEY'))
{
    header("HTTP/1.1 404 Not Found");
    exit(file_get_contents('./../404.php'));
}

//Проверяем зашел ли пользователь
if($user === false)
    echo '<h3>Доступ закрыт, Вы не вошли в систему!</h3>'."\n";

if(!empty($user)) {
    echo '<h3>Поздравляю, Вы вошли в систему!</h3>' . "\n";
    sleep(1);
    header("Location: /");
}