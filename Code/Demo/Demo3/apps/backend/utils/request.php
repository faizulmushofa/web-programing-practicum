<?php

namespace App\Utils;

class Request {
    public static function getJson() :array{
        $raw = file_get_contents('php://input');
        $data = json_decode($raw,true);
        return is_array($data) ? $data :[];
    }
    public static function query(string $key, mixed $default = null): mixed {
        return $_GET[$key] ?? $default;
    }
}
