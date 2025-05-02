<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Core\Flash;
use App\Core\Redirect;
use App\Core\View;

class ApiUserController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function apiGetUser($id)
    {
        try {
            $user = $this->userModel->getUser($id);
            if ($user) {
                $user['name'] = htmlspecialchars($user['name']);
                $user['email'] = htmlspecialchars($user['email']);
                unset($user['password']);
                header('Content-Type: application/json');
                echo json_encode($user, JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
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
            header('Content-Type: application/json');
            echo json_encode($users, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function apiCreateUser()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $errors = $this->validate($data,'create');
            if (empty($errors)) {
                $uuid = uniqid();
                $data['name'] = htmlspecialchars($data['name']);
                $data['email'] = htmlspecialchars($data['email']);
                $this->userModel->createUser($uuid, $data['name'], $data['email'], $data['password']);
                http_response_code(201);
                header('Content-Type: application/json');
                echo json_encode(['success' => 'User created successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['error' => implode(' ', $errors)]);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function apiUpdateUser($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $errors = $this->validate($data);
            if (empty($errors)) {
                $this->userModel->updateUser($id, $data['name'], $data['email'], $data['password']);
                header('Content-Type: application/json');
                echo json_encode(['success' => 'User updated successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['error' => implode(' ', $errors)]);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function apiDeleteUser($id)
    {
        try {
            $this->userModel->deleteUser($id);
            header('Content-Type: application/json');
            echo json_encode(['success' => 'User deleted successfully']);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    protected function validate($data, $action = 'update')
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = 'Name is required.';
        }

        if (empty($data['email'])) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }elseif ($action=='create' && $this->userModel->emailExists($data['email'])) {
            $errors[] = 'Email already exists.';
        }
        

        if (empty($data['password'])) {
            $errors[] = 'Password is required.';
        }

        return $errors;
    }
}