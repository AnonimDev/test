<?php

//Ключ защиты
if(!defined('KEY'))
{
    header("HTTP/1.1 404 Not Found");
    exit(file_get_contents('./../../404.php'));
}

//Если нажата кнопка то обрабатываем данные
if(isset($_POST['submit']))
{
    if(empty($_POST['login']))
        $err[] = 'Не введен Логин';

    if(empty($_POST['pass']))
        $err[] = 'Не введен Пароль';

    //Проверяем наличие ошибок и выводим пользователю
    if(count($err) > 0)
        echo showErrorMessage($err);
    else
    {
        $login = security_input($_POST['login']);
        /*Проверяем существует ли у нас
        такой пользователь в БД*/
        $res = $db_connect->query("SELECT * FROM `users` WHERE `login` = '$login'") or die($db_connect->error);


        //Если логин совподает, проверяем пароль
        if($res->num_rows > 0)
        {
            //Получаем данные из таблицы
            $row = $res->fetch_assoc();


            $password = security_input($_POST['pass']);
            $salt = $row['salt'];
            //$hash = crypt($password, $salt);
            $hash_db = $row['pass'];


            if(md5(crypt($password, $salt)) == $hash_db)
            {
                $_SESSION['user'] = $login;

                //Сбрасываем параметры
                header('Location:'. HOST .'');
                exit;
            }
            else
                echo showErrorMessage('Неверный пароль!');
        }
        else
            echo showErrorMessage('Логин <b>'. $_POST['login'] .'</b> не найден!');
    }

}