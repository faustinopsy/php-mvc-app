<?php
namespace App\core;
use App\core\Flash;
class Redirect {
    public static function to($location) {
        header("Location: " . $location);
        exit();
    }

    public static function with($location, $message, $input = null) {
        Flash::set($_ENV['FLASH_MESSAGE_KEY'], $message);
        if ($input !== null) {
            Flash::setOldInput($_ENV['FLASH_OLD_INPUT_KEY'] ?? 'old_input', $input);
        }
        self::to($location);
    }

}