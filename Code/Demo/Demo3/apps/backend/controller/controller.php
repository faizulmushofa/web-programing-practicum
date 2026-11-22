<?php

namespace App\Controller;

require_once __DIR__ . '/../utils/request.php';
require_once __DIR__ . '/../utils/response.php';

use App\Utils\Request;
use App\Utils\Response;

abstract class Controller {

    protected function getJsonBody(): array {
        return Request::getJson();
    }

    protected function query(string $key, mixed $default = null): mixed {
        return Request::query($key, $default);
    }

    protected function success(string $message, mixed $data = null, int $status = 200): void {
        Response::success($message, $data, $status);
    }

    protected function error(string $message, mixed $errors = null, int $status = 400): void {
        Response::error($message, $errors, $status);
    }
}
