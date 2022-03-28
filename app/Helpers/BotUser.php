<?php

namespace app\Helpers;

use App\Models\User;

class BotUser{

    function BotUserName()
    {
        $username = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            return substr(str_shuffle($username),0,8);
    }

    function BotName()
    {
        $name = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            return substr(str_shuffle($name),0,8);
    }

}


?>