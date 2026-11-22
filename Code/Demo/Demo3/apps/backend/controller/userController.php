<?php

namespace App\Controller;

require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../service/userService.php';

use App\Service\UserService;
use InvalidArgumentException;

class UserController extends Controller {
    private UserService $service;

    public function __construct() {
        $this->service = new UserService();
    }

    public function getProfile(): void {
        $id = $this->query('id');

        if (!$id) {
            throw new InvalidArgumentException("Parameter 'id' wajib diisi.");
        }

        $user = $this->service->getUserProfileById((int)$id);
        $this->success("Data profil ditemukan.", $user);
    }

    public function getAllUsers(): void {
        $users = $this->service->getUsers();
        $this->success("Daftar user berhasil diambil.", $users);
    }
}
