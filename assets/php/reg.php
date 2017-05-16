<?php

if(isset($_GET['status']) and $_GET['status'] == 'ok') {
    echo '<b>Вы успешно зарегистрировались и теперь можете авторизоваться! </b>';
}

if(isset($_POST['submit']))
{
    //Утюжим пришедшие данные
    if(empty($_POST['email']))
        $err[] = 'Поле Email не может быть пустым!';
    else
    {
        if(!preg_match("/^[a-z0-9_.-]+@([a-z0-9]+.)+[a-z]{2,6}$/i", $_POST['email']))
            $err[] = 'Не правильно введен E-mail'."\n";
    }

    if(empty($_POST['pass']))
        $err[] = 'Поле Пароль не может быть пустым';

    if(empty($_POST['pass2']))
        $err[] = 'Поле Подтверждения пароля не может быть пустым';

    if(empty($_POST['date']))
        $err[] = 'Поле Дата рождения не может быть пустым';
    //Проверяем наличие ошибок и выводим пользователю
    if(count($err) > 0)
        echo showErrorMessage($err);
    else
    {
        /*Продолжаем проверять введеные данные
        Проверяем на совподение пароли*/
        if($_POST['pass'] != $_POST['pass2'])
            $err[] = 'Пароли не совподают';

        //Проверяем наличие ошибок и выводим пользователю
        if(count($err) > 0)
            echo showErrorMessage($err);
        else
        {
            $email = security_input($_POST['email']);
            /*Проверяем существует ли у нас
            такой пользователь в БД*/
            $res = $db_connect->query("SELECT `login` FROM `users` WHERE `login` = '$email'") or die($db_connect->error);

            if($res->num_rows > 0)
                $err[] = 'К сожалению Логин: <b>'. $_POST['email'] .'</b> занят!';

            //Проверяем наличие ошибок и выводим пользователю
            if(count($err) > 0){
                echo showErrorMessage($err);
            }
            else {
                $date = security_input($_POST['date']);

                $date1 = new DateTime($date);
                $date2 = new DateTime();

                $bor = $date1->diff($date2)->format("%y");;

                if( $bor < 5 ) {
                    $err[] = 'Too young!';
                    if(count($err) > 0){
                        echo showErrorMessage($err);
                    }
                }
                elseif( $bor > 150 ) {
                    $err[] = 'Too old!';
                    if(count($err) > 0){
                        echo showErrorMessage($err);
                    }
                }
                else
                {
                    //Получаем ХЕШ соли
                    $salt = salt();

                    $pass = md5(crypt($_POST['pass'], $salt));
                    //Солим пароль
                    //$pass = md5(md5($_POST['pass']).$salt);

                    /*Если все хорошо, пишем данные в базу*/

                    $res = $db_connect->query("INSERT INTO `users` (`login`, `pass`, `salt`, `date`, `age`)VALUES('{$email}', '{$pass}', '{$salt}', '{$date}', '{$bor}')") or die($db_connect->error);

                    //Сбрасываем параметры
                    header('Location:' . HOST . '?mode=reg&status=ok');
                    exit;
                }
            }
        }
    }
}
