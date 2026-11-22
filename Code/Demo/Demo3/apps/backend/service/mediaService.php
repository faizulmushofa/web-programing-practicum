<?php

namespace App\Service;

require_once __DIR__ . '/../model/media.php';

use App\Model\Media;
use InvalidArgumentException;
use OutOfBoundsException;
use RuntimeException;

class MediaService {

    public function getAllMedia(): array {
        return Media::findAll();
    }

    public function getMediaDetail(int $id): array {
        $media = Media::findById($id);
        if (!$media) {
            throw new OutOfBoundsException("Media dengan id {$id} tidak ditemukan.");
        }

        return $media;
    }

    public function addMedia(array $data): int {
        if (empty($data['title'])) {
            throw new InvalidArgumentException("Judul media wajib diisi.");
        }

        $media = new Media(
            $data['title'],
            $data['url_image'] ?? '',
            isset($data['rating']) ? (float)$data['rating'] : null,
            isset($data['episodes']) ? (int)$data['episodes'] : null,
            $data['status'] ?? null
        );

        if (!$media->create()) {
            throw new RuntimeException("Gagal menambahkan media ke database.");
        }

        return $media->getId();
    }
}
