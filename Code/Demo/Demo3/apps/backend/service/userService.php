<?php

namespace App\Service;

require_once __DIR__ . '/../model/user.php';

use App\Model\User;
use OutOfBoundsException;

class UserService {

    public function getUserProfileById(int $id): array {
        $user = User::findById($id);

        if ($user === null) {
            throw new OutOfBoundsException("User dengan id {$id} tidak ditemukan.");
        }

        return $user;
    }
    public function getUsers(): array {
        $user = User::findAll();

        if ($user === null) {
            throw new OutOfBoundsException("User dengan tidak ditemukan.");
        }

        return $user;
    }

    public function updateProfile(int $id, array $data): bool {
        // TODO: update data user
        return false;
    }
}
