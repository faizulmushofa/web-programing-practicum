<?php

namespace App\Service;

require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../utils/hash.php';

use App\Model\User;
use App\Utils\Hash;
use InvalidArgumentException;
use DomainException;
use RuntimeException;

class AuthService {

    public function register(array $data): int {
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            throw new InvalidArgumentException("Nama, email, dan password wajib diisi.");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Format email tidak valid.");
        }

        if (strlen($data['password']) < 6) {
            throw new InvalidArgumentException("Password minimal 6 karakter.");
        }

        if (User::findByEmail($data['email']) !== null) {
            throw new DomainException("Email sudah terdaftar.");
        }

        $user = new User($data['name'], $data['email'], $data['password']);
        if (!$user->create()) {
            throw new RuntimeException("Gagal mendaftarkan user ke database.");
        }

        return $user->getId();
    }

    public function login(string $email, string $password): array {
        $email = trim($email);

        if (empty($email) || empty($password)) {
            throw new InvalidArgumentException("Email dan password wajib diisi.");
        }

        $user = User::findByEmail($email);
        if (!$user || !Hash::verify($password, $user['password'])) {
            throw new UnauthorizedAccessException("Email atau password salah.");
        }

        return [
            'id'    => (int)$user['id'],
            'name'  => $user['name'],
            'email' => $user['email']
        ];
    }
}

class UnauthorizedAccessException extends RuntimeException {}
