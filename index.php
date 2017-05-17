<?php


//Запускаем сессию
session_start();

//Устанавливаем кодировку и вывод всех ошибок
header('Content-Type: text/html; charset=UTF8');
error_reporting(E_ALL);

//Включаем буферизацию содержимого
ob_start();

//Определяем переменную для переключателя
$mode = isset($_GET['mode'])  ? $_GET['mode'] : false;
$err = array();

//Устанавливаем ключ защиты
define('KEY', true);

//Подключаем конфигурационный файл
include './config.php';

//Подключаем скрипт с функциями
include './assets/php/funct.php';

//подключаем MySQL
include './assets/php/bd.php';


switch ($mode) {
    //Подключаем обработчик с формой регистрации
    case 'reg':
        include './assets/php/reg.php';
        include './assets/html/reg_form.html';
        break;
    //Подключаем обработчик с формой авторизации
    case 'auth':
        include './assets/php/auth.php';
        include './assets/html/auth_form.html';
        break;
    case 'plu':
        include './assets/php/plu.php';
        include './assets/html/plus.html';
        break;
    default:
        include './assets/php/auth.php';
        include './assets/html/auth_form.html';
        break;
}
//Получаем данные с буфера
$content = ob_get_contents();
ob_end_clean();

//Подключаем наш шаблон
include './assets/html/index.html';

?>			