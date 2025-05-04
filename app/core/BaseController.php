<?php

namespace App\Core;

use Exception;

abstract class BaseController
{
    protected function extractAndValidateData($validator, $isUpdate=false ,$data = null)
    {
        if (!$data) {
            $data = json_decode(file_get_contents('php://input'), true);
        }

        if (!$data) {
            throw new Exception('Invalid JSON input');
        }

        $errors = $validator->validate($data, $isUpdate);

        if (!empty($errors)) {
            throw new Exception(implode(' ', $errors));
        }

        return $data;
    }

    protected function jsonResponse($statusCode, $data)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }
}