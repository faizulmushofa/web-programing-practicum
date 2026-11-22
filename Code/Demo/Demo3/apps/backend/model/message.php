<?php

namespace App\Model;

require_once __DIR__ . '/../config/database.php';

use App\Config\Database;

class Message {
    
    private ?int $id;
    private string $name;
    private string $email;
    private string $detail;

    public function __construct(string $name = '', string $email = '', string $detail = '', ?int $id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->detail = $detail;
    }

    public function create() : bool {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "INSERT INTO message (name, email, detail) VALUES (:name, :email, :detail)"
        );

        $success = $stmt->execute([
            ':name'   => $this->name,
            ':email'  => $this->email,
            ':detail' => $this->detail
        ]);

        if ($success) {
            $this->id = (int) $db->lastInsertId();
        }

        return $success;
    }

    public static function findById(int $id): ?array {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM message WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $message = $stmt->fetch();

        return $message ?: null;
    }

    public static function findByEmail(string $email): array {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM message WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $messages = $stmt->fetchAll();

        return $messages ?: [];
    }
    public static function findAll(): array {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM message");
        $stmt->execute();
        $messages = $stmt->fetchAll();

        return $messages ?: [];
    }

    public function getId(): ?int {
        return $this->id;
    }
}
