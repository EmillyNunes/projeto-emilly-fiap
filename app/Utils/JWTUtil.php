<?php

namespace App\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTUtil
{
    private static $key = 'fiap_secret';
    private static $algorithm = 'HS256';

    public static function createToken($payload)
    {
        return JWT::encode($payload, self::$key, self::$algorithm);
    }

    public static function decodeToken($token)
    {
        return JWT::decode($token, new Key(self::$key, self::$algorithm));
    }
}
