<?php

if(!defined('KEY'))
{
    header("HTTP/1.1 404 Not Found");
    exit(file_get_contents('./../404.php'));
}

//Mysqli подключение
$db_connect = mysqli_connect( DBSERVER, DBUSER, DBPASSWORD ) or die(ERROR_CONNECT);

//define('CONNECT', $db_connect);
$db_connect->select_db( DATABASE ) or die(NO_DB_SELECT);

if (!mysqli_set_charset($db_connect, "utf8"));
//////////