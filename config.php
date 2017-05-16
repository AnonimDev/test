


<?php
/**
 * Конфигурационный файл
 */

//Ключ защиты
if(!defined('KEY'))
{
    header("HTTP/1.1 404 Not Found");
    exit(file_get_contents('./404.php'));
}

//Адрес базы данных
define('DBSERVER','localhost');

//Логин БД
define('DBUSER','root');

//Пароль БД
define('DBPASSWORD','');

//БД
define('DATABASE','reg');

//Errors
define('ERROR_CONNECT','Немогу соеденится с БД');

//Errors
define('NO_DB_SELECT','Данная БД отсутствует на сервере');

//Адрес хоста сайта
define('HOST','http://'. $_SERVER['HTTP_HOST'] .'/');

?>


