<?php

//if(isset($_GET['status']) and $_GET['status'] == 'ok') {
//    echo '<b>Вы успешно зарегистрировались и теперь можете авторизоваться! </b>';
//}

if(isset($_POST['submit']))
{
    //Утюжим пришедшие данные
    if(empty($_POST['login']))
        $err[] = 'Поле Логин не может быть пустым!';

    if(empty($_POST['pass']))
        $err[] = 'Поле Пароль не может быть пустым';

    if(empty($_POST['pass2']))
        $err[] = 'Поле Подтверждения пароля не может быть пустым';

    if(empty($_POST['day']) or empty($_POST['month']) or empty($_POST['year']))
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
            $login = security_input($_POST['login']);
            /*Проверяем существует ли у нас
            такой пользователь в БД*/
            $res = $db_connect->query("SELECT `login` FROM `users` WHERE `login` = '$login'") or die($db_connect->error);

            if($res->num_rows > 0)
                $err[] = 'К сожалению Логин: <b>'. $_POST['login'] .'</b> занят!';

            //Проверяем наличие ошибок и выводим пользователю
            if(count($err) > 0){
                echo showErrorMessage($err);
            }
            else
            {
                //$date = security_input($_POST['date']);
                $day = security_input($_POST['day']);
                $month = security_input($_POST['month']);
                $year = security_input($_POST['year']);

                if (checkdate( $month , $day , $year )) {

                    $date = $day . "." . $month . "." . $year;

                    $date1 = new DateTime($date);
                    $date2 = new DateTime();

                    $bor = $date1->diff($date2)->format("%y");;

                    if ($bor < 5) {
                        $err[] = 'Too young!';
                        if (count($err) > 0) {
                            echo showErrorMessage($err);
                        }
                    } elseif ($bor > 150) {
                        $err[] = 'Too old!';
                        if (count($err) > 0) {
                            echo showErrorMessage($err);
                        }
                    } else {

                        $pass = password_hash(security_input($_POST['pass']), PASSWORD_DEFAULT);
                        /*Если все хорошо, пишем данные в базу*/
                        $res = $db_connect->query("INSERT INTO `users` (`login`, `pass`, `date`, `age`, `click`)VALUES('{$login}', '{$pass}', '{$date}', '{$bor}', 0)") or die($db_connect->error);

                        $_SESSION['user'] = $login;
                        header('Location:' . HOST . '?mode=plu');
                        exit;
                    }

                }
                else
                {
                    $err[] = 'Дата введена некорректно.';
                    if (count($err) > 0) {
                        echo showErrorMessage($err);
                    }
                }
            }
        }
    }
}
