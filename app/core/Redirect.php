<?php
namespace App\core;
use App\core\Flash;
class Redirect {
    public static function to($location) {
        header("Location: " . $location);
        exit();
    }

    public static function with($location, $message) {
        Flash::set('flash_message', $message);
        self::to($location);
    }

}