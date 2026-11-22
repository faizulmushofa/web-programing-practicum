<?php

namespace App\Model;

require_once __DIR__ . '/../config/database.php';

use App\Config\Database;
use PDO;

class Media {
    private ?int $id;
    private string $title;
    private string $urlImage;
    private ?float $rating;
    private ?int $episodes;
    private ?string $status;

    public function __construct(
        string $title = '',
        string $urlImage = '',
        ?float $rating = null,
        ?int $episodes = null,
        ?string $status = null,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->urlImage = $urlImage;
        $this->rating = $rating;
        $this->episodes = $episodes;
        $this->status = $status;
    }

    public function create() : bool {
        $db = Database::getConnection();

        $stmt = $db->prepare(
            "INSERT INTO media (title, url_image, rating, episodes, status) 
             VALUES (:title, :url_image, :rating, :episodes, :status)"
        );

        $success = $stmt->execute([
            ':title'     => $this->title,
            ':url_image' => $this->urlImage,
            ':rating'    => $this->rating,
            ':episodes'  => $this->episodes,
            ':status'    => $this->status
        ]);

        if ($success) {
            $this->id = (int) $db->lastInsertId();
        }

        return $success;
    }

    public static function findById(int $id): ?array {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM media WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $media = $stmt->fetch();

        return $media ?: null;
    }

    public static function findAll(): array {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM media");
        $stmt->execute();
        $media = $stmt->fetchAll();

        return $media ?: [];
    }

    public function getId(): ?int {
        return $this->id;
    }
}
