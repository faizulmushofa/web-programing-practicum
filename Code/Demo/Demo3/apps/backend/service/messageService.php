<?php

namespace App\Service;

require_once __DIR__ . '/../model/message.php';

use App\Model\Message;
use InvalidArgumentException;
use OutOfBoundsException;
use RuntimeException;

class MessageService {

    public function sendMessage(array $data): int {
        if (empty($data['name']) || empty($data['email']) || empty($data['detail'])) {
            throw new InvalidArgumentException("Nama, email, dan pesan wajib diisi.");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Format email tidak valid.");
        }

        $message = new Message($data['name'], $data['email'], $data['detail']);
        if (!$message->create()) {
            throw new RuntimeException("Gagal menyimpan pesan ke database.");
        }

        return $message->getId();
    }

    public function getMessagesByEmail(string $email): array {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Format email tidak valid.");
        }

        return Message::findByEmail($email);
    }

    public function getMessageDetail(int $id): array {
        $message = Message::findById($id);
        if (!$message) {
            throw new OutOfBoundsException("Pesan dengan id {$id} tidak ditemukan.");
        }

        return $message;
    }

    public function getAllMessage(){
        $message = Message::findAll();
    
        return $message;
    }
}
