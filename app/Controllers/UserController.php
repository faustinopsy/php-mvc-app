<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Core\Redirect;
use App\Core\View;
use App\Core\BaseController;
use App\Validators\UserValidator;

class UserController extends BaseController
{
    protected $userModel;
    protected $userValidator;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userValidator = new UserValidator($this->userModel);
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
        try {
            $data = $this->extractAndValidateData($this->userValidator, false);
            $uuid = uniqid();
            $this->userModel->createUser($uuid, $data['name'], $data['email'], $data['password']);
            Redirect::with('/', ['success' => 'User created successfully.']);
        } catch (\Exception $e) {
            Redirect::with('/user/create', ['error' => $e->getMessage()]);
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
        try {
            $data = $this->extractAndValidateData($this->userValidator, true);
            $this->userModel->updateUser($id, $data['name'], $data['email'], $data['password']);
            Redirect::with('/', ['success' => 'User updated successfully.']);
        } catch (\Exception $e) {
            Redirect::with("/user/edit/$id", ['error' => $e->getMessage()]);
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