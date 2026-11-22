<?php

namespace App\Controller;

require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../service/mediaService.php';

use App\Service\MediaService;
use InvalidArgumentException;

class MediaController extends Controller {
    private MediaService $service;

    public function __construct() {
        $this->service = new MediaService();
    }

    public function getAll(): void {
        $mediaList = $this->service->getAllMedia();
        $this->success("Daftar media berhasil diambil.", $mediaList);
    }

    public function getDetail(): void {
        $id = $this->query('id');

        if (!$id) {
            throw new InvalidArgumentException("Parameter 'id' wajib diisi.");
        }

        $media = $this->service->getMediaDetail((int)$id);
        $this->success("Detail media ditemukan.", $media);
    }

    public function create(): void {
        $body = $this->getJsonBody();
        $mediaId = $this->service->addMedia($body);
        $this->success("Media berhasil ditambahkan.", ['id' => $mediaId], 201);
    }
}
