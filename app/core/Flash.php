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
            foreach ($_SESSION[$type] as $key => $value) {
                $message = $value;
            }
            unset($_SESSION[$type]);
            return $message;
        }
        return null;
    }
}