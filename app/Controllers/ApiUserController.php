<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Entities\User;
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
                $this->jsonResponse(200, $user->toArray());
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
            $usersArray = array_map(function(User $user) {
                return $user->toArray();
            }, $users);
            $this->jsonResponse(200, $usersArray);
        } catch (\Exception $e) {
            $this->jsonResponse(500, ['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function apiCreateUser()
    {
        try {
            $data = $this->extractAndValidateData($this->userValidator, false);
            $uuid = uniqid();
            $this->userModel->createUser($uuid, $data['name'], $data['email'], $data['password']);
            $this->jsonResponse(201, ['success' => 'User created successfully']);
        } catch (\Exception $e) {
            $this->jsonResponse(400, ['error' => $e->getMessage()]);
        }
    }

    public function apiUpdateUser($id)
    {
        try {
            $data = $this->extractAndValidateData($this->userValidator, true);
            $passwordToUpdate = (!empty($data['password'])) ? $data['password'] : null;
            $this->userModel->updateUser($id, $data['name'], $data['email'], $passwordToUpdate);
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