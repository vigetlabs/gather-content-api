<?php

namespace GatherContent;

class Configuration
{
    static $email   = null;
    static $api_key = null;

    public static function configure($email, $api_key)
    {
        self::$email   = $email;
        self::$api_key = $api_key;
    }
}