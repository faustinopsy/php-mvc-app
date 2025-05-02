<?php
namespace App\core;

class Flash {
    public static function set($type, $message)
    {
        $_SESSION['flash'][$type] = $message;
    }

    public static function get($type)
    {
        if (isset($_SESSION['flash'][$type])) {
            $message = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $message;
        }
        return null;
    }
}