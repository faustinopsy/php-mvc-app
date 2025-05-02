<?php
namespace App\core;

class Redirect {
    public static function to($location) {
        header("Location: " . $location);
        exit();
    }

    public static function with($location, $message) {
        session_start();
        $_SESSION['flash_message'] = $message;
        self::to($location);
    }

}