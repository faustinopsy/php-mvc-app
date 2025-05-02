<?php

namespace App\Core;

use Exception;

class BaseController
{
    protected function extractAndValidateData($action, $data = null, $funcao=null)
    {
        if (!$data) {
            $data = json_decode(file_get_contents('php://input'), true);
        }

        if (!$data) {
            throw new Exception('Invalid JSON input');
        }

        $errors = $this->validate($data, $action, $funcao);

        if (!empty($errors)) {
            throw new Exception(implode(' ', $errors));
        }

        $data['name'] = htmlspecialchars($data['name']);
        $data['email'] = htmlspecialchars($data['email']);

        return $data;
    }

    protected function validate($data, $action = 'update', $funcao=null)
    {
        $errors = [];
       
        if (empty($data['name'])) {
            $errors[] = 'Name is required.';
        }

        if (empty($data['email'])) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }

        if ($action === 'create' && $funcao->emailExists($data['email'])) {
            $errors[] = 'Email already exists.';
        }

        if (empty($data['password'])) {
            $errors[] = 'Password is required.';
        }

        return $errors;
    }

    protected function jsonResponse($statusCode, $data)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }
}