<?php

namespace app\libs\password;

/**
 * Descripción de Password
 */

final class Password {
    
    const COST = 10;

    private function __construct(){}

    //*************** Métodos ***************

    public static function hash($pass):string {
        return password_hash($pass, PASSWORD_DEFAULT, array("cost" => self::COST));
    }
    
    public static function verify($pass, $hash): bool{
        return password_verify($pass, $hash);
    }
    
    public static function needsRehash($hash){
        return password_needs_rehash($hash, PASSWORD_DEFAULT, array("cost" => self::COST));
    }
    
    public static function randomHash($long = 10){
        $salt = 'abchefghknpqrstuvwxyz';
        $salt .= 'ACDEFHKNPRSTUVWXYZ';
        $salt .= '0123456789';
        $i = 0;
        $str = '';
        srand((double)microtime()*1000000);
        while ($i < $long) {
                $num = rand(0, strlen($salt)-1);
                $str .= substr($salt, $num, 1);
                $i++;
        }
        return $str;
    }
}