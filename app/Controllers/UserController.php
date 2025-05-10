<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Core\Redirect;
use App\Core\View;
use App\Entities\User;
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
        View::render('user/index', [
            'users' => $users,
            'h' => fn($str) => htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8')
        ]);
    }

    public function create()
    {
        View::render('user/create');
    }

    public function store()
    {
        try {
            $data = $this->extractAndValidateData($this->userValidator, false, $_POST);
            $uuid = uniqid();
            $this->userModel->createUser($uuid, $data['name'], $data['email'], $data['password']);
            Redirect::with('/', ['success' => 'User created successfully.']);
        } catch (\Exception $e) {
            Redirect::with('/user/create', ['error' => $e->getMessage()], $_POST);
        }
    }

    public function edit($id)
    {
        $user = $this->userModel->getUser($id);
        if (!$user) {
            Redirect::with('/', ['error' => 'User not found.']);
            return;
        }
        View::render('user/edit', ['user' => $user,
            'h' => fn($str) => htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8')]);
    }

    public function update($id)
    {
        try {
            $data = $this->extractAndValidateData($this->userValidator, true, $_POST);
            $this->userModel->updateUser($id, $data['name'], $data['email'], $data['password']);
            $passwordToUpdate = (!empty($data['password'])) ? $data['password'] : null;
            $this->userModel->updateUser($id, $data['name'], $data['email'], $passwordToUpdate);
            Redirect::with('/', ['success' => 'User updated successfully.']); // Corrected key
        } catch (\Exception $e) {
            Redirect::with("/user/edit/$id", ['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            Redirect::with('/', ['error' => 'Token csrf inválido.']);
            exit;
        }
        try {
            $this->userModel->deleteUser($id);
            Redirect::with('/',['success' => 'User deleted successfully.']); // Corrected key
        } catch (\Exception $e) {
            Redirect::with('/', ['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $user = $this->userModel->getUser($id);
        if (!$user) {
            Redirect::with('/', ['error' => 'User not found.']);
            return;
        }
        View::render('user/show', ['user' => $user,
            'h' => fn($str) => htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8')]);
    }
}