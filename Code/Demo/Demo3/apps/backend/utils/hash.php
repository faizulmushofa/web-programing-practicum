<?php

namespace App\Utils;

class Hash{

    public static function create(string $password) : string{
        return password_hash($password,PASSWORD_BCRYPT);
    }
    public static function verify (string $password,string $hash){
        return password_verify($password,$hash);
    }

}
