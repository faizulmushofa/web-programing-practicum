<?php

namespace App\Model;

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/hash.php';

use App\Config\Database;
use App\Utils\Hash;

class User {

    private ?int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(string $name = '', string $email = '', string $password = '', ?int $id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function create() : bool {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)"
        );

        $hashPassword = Hash::create($this->password);

        $success = $stmt->execute([
            ':name'     => $this->name,
            ':email'    => $this->email,
            ':password' => $hashPassword
        ]);

        if ($success) {
            $this->id = (int) $db->lastInsertId();
        }

        return $success;
    }

    public static function findById(int $id): ?array {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT id, name, email FROM users WHERE id = :id"
        );

        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public static function findByEmail(string $email): ?array {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT * FROM users WHERE email = :email"
        );

        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public static function findAll(): ?array {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "SELECT * FROM users"
        );

        $stmt->execute();
        $user = $stmt->fetchAll();

        return $user ?: null;
    }

    public function getId(): ?int {
        return $this->id;
    }
}
