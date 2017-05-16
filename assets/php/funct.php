<?php
/**
 * Created by PhpStorm.
 * User: Аноним
 * Date: 15.05.2017
 * Time: 12:32
 */


function security_input($data){
    GLOBAL $db_connect;
    $data = $db_connect->real_escape_string($data);
//    $data = htmlspecialchars($data, ENT_QUOTES);
//    $data = htmlentities($data);
//    $data = strip_tags($data);
    return $data;
}


function showErrorMessage($data)
{
    $err = '<ul>'."\n";

    if(is_array($data))
    {
        foreach($data as $val)
            $err .= '<li style="color:red;">'. $val .'</li>'."\n";
    }
    else
        $err .= '<li style="color:red;">'. $data .'</li>'."\n";

    $err .= '</ul>'."\n";

    return $err;
}

function salt()
{
    $salt = substr(md5(uniqid()), -8);
    return $salt;
}