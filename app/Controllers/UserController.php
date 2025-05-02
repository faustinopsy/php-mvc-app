<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Core\Flash;
use App\Core\Redirect;
use App\Core\View;

class UserController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->getAllUsers();
        foreach ($users as &$user) {
            $user['name'] = htmlspecialchars($user['name']);
            $user['email'] = htmlspecialchars($user['email']);
        }
        unset($user['password']);
        View::render('user/index', ['users' => $users]);
    }

    public function create()
    {
        View::render('user/create');
    }

    public function store()
    {
        $data = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? ''
        ];

        try {
            $errors = $this->validate($data);
            if (empty($errors)) {
                $uuid = uniqid();
                $data['name'] = htmlspecialchars($data['name']);
                $data['email'] = htmlspecialchars($data['email']);
                $this->userModel->createUser($uuid, $data['name'], $data['email'], $data['password']);
                Flash::set('success', 'User created successfully.');
                Redirect::to('/');
            } else {
                Flash::set('error', implode(' ', $errors));
                Redirect::to('/user/create');
            }
        } catch (\Exception $e) {
            Flash::set('error', 'An error occurred: ' . $e->getMessage());
            Redirect::to('/user/create');
        }
    }

    public function edit($id)
    {
        $user = $this->userModel->getUser($id);
        if ($user) {
            $user['name'] = htmlspecialchars($user['name']);
            $user['email'] = htmlspecialchars($user['email']);
        }
        View::render('user/edit', ['user' => $user]);
    }

    public function update($id)
    {
        $data = [
            'name' => $_POST['name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? ''
        ];

        try {
            $errors = $this->validate($data);
            if (empty($errors)) {
                $data['name'] = htmlspecialchars($data['name']);
                $data['email'] = htmlspecialchars($data['email']);
                $this->userModel->updateUser($id, $data['name'], $data['email'], $data['password']);
                Flash::set('success', 'User updated successfully.');
                Redirect::to('/');
            } else {
                Flash::set('error', implode(' ', $errors));
                Redirect::to("/user/edit/$id");
            }
        } catch (\Exception $e) {
            Flash::set('error', 'An error occurred: ' . $e->getMessage());
            Redirect::to("/user/edit/$id");
        }
    }

    public function delete($id)
    {
        try {
            $this->userModel->deleteUser($id);
            Flash::set('success', 'User deleted successfully.');
            Redirect::to('/');
        } catch (\Exception $e) {
            Flash::set('error', 'An error occurred: ' . $e->getMessage());
            Redirect::to('/');
        }
    }

    public function show($id)
    {
        $user = $this->userModel->getUser($id);
        if ($user) {
            $user['name'] = htmlspecialchars($user['name']);
            $user['email'] = htmlspecialchars($user['email']);
        }
        View::render('user/show', ['user' => $user]);
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

    protected function validate($data)
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = 'Name is required.';
        }

        if (empty($data['email'])) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        } elseif ($this->userModel->emailExists($data['email'])) {
            $errors[] = 'Email already exists.';
        }

        if (empty($data['password'])) {
            $errors[] = 'Password is required.';
        }

        return $errors;
    }
}