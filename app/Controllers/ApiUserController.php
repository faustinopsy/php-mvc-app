<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Core\BaseController;
use App\Validators\UserValidator;
class ApiUserController extends BaseController
{
    protected $userModel;
    protected $userValidator;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userValidator = new UserValidator($this->userModel);
    }

    public function apiGetUser($id)
    {
        try {
            $user = $this->userModel->getUser($id);
            if ($user) {
                $user['name'] = htmlspecialchars($user['name']);
                $user['email'] = htmlspecialchars($user['email']);
                unset($user['password']);
                $this->jsonResponse(200, $user);
            } else {
                $this->jsonResponse(404, ['error' => 'User not found']);
            }
        } catch (\Exception $e) {
            $this->jsonResponse(500, ['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function apiGetAllUsers()
    {
        try {
            $users = $this->userModel->getAllUsers();
            foreach ($users as &$user) {
                $user['name'] = htmlspecialchars($user['name']);
                $user['email'] = htmlspecialchars($user['email']);
                unset($user['password']);
            }
            $this->jsonResponse(200, $users);
        } catch (\Exception $e) {
            $this->jsonResponse(500, ['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function apiCreateUser()
    {
        try {
            $data = $this->extractAndValidateData($this->userValidator, false);
            $uuid = uniqid();
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->userModel->createUser($uuid, $data['name'], $data['email'], $hashedPassword);
            $this->jsonResponse(201, ['success' => 'User created successfully']);
        } catch (\Exception $e) {
            $this->jsonResponse(400, ['error' => $e->getMessage()]);
        }
    }

    public function apiUpdateUser($id)
    {
        try {
            $data = $this->extractAndValidateData($this->userValidator, true);
            $this->userModel->updateUser($id, $data['name'], $data['email'], $data['password']);
            $this->jsonResponse(200, ['success' => 'User updated successfully']);
        } catch (\Exception $e) {
            $this->jsonResponse(400, ['error' => $e->getMessage()]);
        }
    }

    public function apiDeleteUser($id)
    {
        try {
            $this->userModel->deleteUser($id);
            $this->jsonResponse(200, ['success' => 'User deleted successfully']);
        } catch (\Exception $e) {
            $this->jsonResponse(500, ['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}