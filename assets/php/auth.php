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
    if(empty($_POST['email']))
        $err[] = 'Не введен Логин';

    if(empty($_POST['pass']))
        $err[] = 'Не введен Пароль';

    //Проверяем наличие ошибок и выводим пользователю
    if(count($err) > 0)
        echo showErrorMessage($err);
    else
    {
        $email = security_input($_POST['email']);
        /*Проверяем существует ли у нас
        такой пользователь в БД*/
        $res = $db_connect->query("SELECT * FROM `users` WHERE `login` = '$email'") or die($db_connect->error);


        //Если логин совподает, проверяем пароль
        if($res->num_rows > 0)
        {
            //Получаем данные из таблицы
            $row = $res->fetch_assoc();


            $password = $_POST['pass'];
            $salt = $row['salt'];
            //$hash = crypt($password, $salt);
            $hash_db = $row['pass'];


            if(md5(crypt($password, $salt)) == $hash_db)
            {
                $_SESSION['user'] = $email;

                //Сбрасываем параметры
                header('Location:'. HOST .'');
                exit;
            }
            else
                echo showErrorMessage('Неверный пароль!');
        }
        else
            echo showErrorMessage('Логин <b>'. $_POST['email'] .'</b> не найден!');
    }

}