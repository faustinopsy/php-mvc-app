<?php

namespace App\Validators;

use App\Models\UserModel;

class UserValidator
{
    protected $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function validate($data, $isUpdate = false)
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = 'Name is required.';
        } elseif (strlen($data['name']) < 3 || strlen($data['name']) > 50) {
            $errors[] = 'Name must be between 3 and 50 characters.';
        }

        if (empty($data['email'])) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        } elseif (!$isUpdate && $this->userModel->emailExists($data['email'])) {
            $errors[] = 'Email already exists.';
        }

        if (empty($data['password'])) {
            $errors[] = 'Password is required.';
        } elseif (strlen($data['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters long.';
        }

        return $errors;
    }
}