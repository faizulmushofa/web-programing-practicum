<?php

namespace App\Controller;

require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../service/authService.php';

use App\Service\AuthService;

class AuthController extends Controller {
    private AuthService $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function register(): void {
        $body = $this->getJsonBody();
        $userId = $this->authService->register($body);
        $this->success("Registrasi berhasil.", ['id' => $userId], 201);
    }

    public function login(): void {
        $body = $this->getJsonBody();
        $email = $body['email'] ?? '';
        $password = $body['password'] ?? '';

        $user = $this->authService->login($email, $password);
        $this->success("Login berhasil.", $user);
    }
}
