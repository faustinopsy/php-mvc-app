<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Core\Redirect;
use App\Core\View;
use App\Core\BaseController;

class UserController extends BaseController
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
            $errors = $this->validate($data, 'create', $this->userModel);
            if (empty($errors)) {
                $uuid = uniqid();
                $data['name'] = htmlspecialchars($data['name']);
                $data['email'] = htmlspecialchars($data['email']);
                $this->userModel->createUser($uuid, $data['name'], $data['email'], $data['password']);
                Redirect::with('/', ['success' => 'User created successfully.']);
            } else {
                Redirect::with('/user/create', ['error' => $errors[0]]);
            }
        } catch (\Exception $e) {
            Redirect::with('/user/create', ['error' => 'An error occurred: ' . $e->getMessage()]);
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
            $errors = $this->validate($data, 'update', $this->userModel);
            if (empty($errors)) {
                $data['name'] = htmlspecialchars($data['name']);
                $data['email'] = htmlspecialchars($data['email']);
                $this->userModel->updateUser($id, $data['name'], $data['email'], $data['password']);
                Redirect::with('/', ['success' => 'User updated successfully.']);
            } else {
                Redirect::with("/user/edit/$id", ['error' => 'Validation failed.']);
            }
        } catch (\Exception $e) {
            Redirect::with("/user/edit/$id", ['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $this->userModel->deleteUser($id);
            Redirect::with('/',['success', 'User deleted successfully.']);
        } catch (\Exception $e) {
            Redirect::with('/', ['error' => 'An error occurred: ' . $e->getMessage()]);
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
}