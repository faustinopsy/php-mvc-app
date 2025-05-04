<?php
namespace App\core;

class Flash {
    public static function set($type,$message)
    {
        foreach ($message as $key => $value) {
                $_SESSION[$type][$key] = $value;
        }
    }

    public static function get($type)
    {
        if (isset($_SESSION[$type])) {
            $message = $_SESSION[$type];
            unset($_SESSION[$type]);
            return $message;
        }
        return null;
    }
    public static function setOldInput(string $key, array $input)
    {
        $_SESSION[$key] = $input;
    }

    public static function getOldInput(string $key): ?array
    {
        if (isset($_SESSION[$key])) {
            $input = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $input;
        }
        return null;
    }
}