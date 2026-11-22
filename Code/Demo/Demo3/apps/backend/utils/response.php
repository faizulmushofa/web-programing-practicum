<?php

namespace App\Utils;

class Response {

    public static function json(bool $success,string $message,mixed $data = null,int $statuscode = 200,mixed $error = null) : void {
        http_response_code($statuscode);
        header('Content-Type: application/json; charset=utf-8');

        $payload = [
            'success' => $success,
            'message' => $message,
            'data' => $data
        ];

        if($error !== null){
            $payload['error'] = $error;
        }

        echo json_encode($payload);

        exit;
    }

    public static function success(string $message, mixed $data = null, int $statusCode = 200): void {
        self::json(true, $message, $data, $statusCode);
    }

    public static function error(string $message, mixed $errors = null, int $statusCode = 400): void {
        self::json(false, $message, null, $statusCode, $errors);
    }
}
