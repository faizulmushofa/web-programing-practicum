<?php

namespace App\Controller;

require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../service/messageService.php';

use App\Service\MessageService;
use InvalidArgumentException;

class MessageController extends Controller {
    private MessageService $service;

    public function __construct() {
        $this->service = new MessageService();
    }

    public function send(): void {
        $body = $this->getJsonBody();
        $messageId = $this->service->sendMessage($body);
        $this->success("Pesan Anda berhasil dikirim.", ['id' => $messageId], 201);
    }

    public function getDetail(): void {
        $id = $this->query('id');

        if (!$id) {
            throw new InvalidArgumentException("Parameter 'id' wajib diisi.");
        }

        $msg = $this->service->getMessageDetail((int)$id);
        $this->success("Detail pesan ditemukan.", $msg);
    }

    public function getHistoryByEmail(): void {
        $email = $this->query('email');

        if (!$email) {
            throw new InvalidArgumentException("Parameter 'email' wajib diisi.");
        }

        $messages = $this->service->getMessagesByEmail($email);
        $this->success("Riwayat pesan berhasil diambil.", $messages);
    }

    public function getAllMessage(): void {
        $messages = $this->service->getAllMessage();
        $this->success("Semua pesan berhasil diambil.", $messages);
    }
}
