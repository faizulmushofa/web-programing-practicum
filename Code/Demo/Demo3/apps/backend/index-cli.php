<?php

require_once __DIR__ . '/service/mediaService.php';
require_once __DIR__ . '/service/authService.php';
require_once __DIR__ . '/service/userService.php';
require_once __DIR__ . '/service/messageService.php';

use App\Service\MediaService;
use App\Service\AuthService;
use App\Service\UserService;
use App\Service\MessageService;

$mediaService   = new MediaService();
$authService    = new AuthService();
$userService    = new UserService();
$messageService = new MessageService();

function prompt(string $label): string {
    echo $label . " ";
    return trim(fgets(STDIN));
}

$currentUser = null;

while (true) {
    echo PHP_EOL;
    echo "==========================================================" . PHP_EOL;
    echo "       FLIPPLAY ENTERTAINMENT ENGINE - INTERACTIVE CLI    " . PHP_EOL;
    echo "==========================================================" . PHP_EOL;
    if ($currentUser !== null) {
        echo " [Status: Login sebagai {$currentUser['name']} ({$currentUser['email']})]" . PHP_EOL;
    } else {
        echo " [Status: Belum Login / Tamu]" . PHP_EOL;
    }
    echo "----------------------------------------------------------" . PHP_EOL;
    echo " [MEDIA SERVICE]" . PHP_EOL;
    echo "   1. Tampilkan Semua Media" . PHP_EOL;
    echo "   2. Cari Detail Media Berdasarkan ID" . PHP_EOL;
    echo "   3. Tambah Media Baru ke Library" . PHP_EOL;
    echo PHP_EOL;
    echo " [AUTH SERVICE]" . PHP_EOL;
    echo "   4. Registrasi Pengguna Baru" . PHP_EOL;
    echo "   5. Login Pengguna" . PHP_EOL;
    echo "   6. Logout Pengguna" . PHP_EOL;
    echo PHP_EOL;
    echo " [USER SERVICE]" . PHP_EOL;
    echo "   7. Tampilkan Profil Saya (Session Login)" . PHP_EOL;
    echo "   8. Cari Profil Pengguna Berdasarkan ID" . PHP_EOL;
    echo "   9. Tampilkan Semua Pengguna Terdaftar" . PHP_EOL;
    echo PHP_EOL;
    echo " [MESSAGE SERVICE]" . PHP_EOL;
    echo "  10. Kirim Pesan Feedback Kontak" . PHP_EOL;
    echo "  11. Cari Detail Pesan Berdasarkan ID" . PHP_EOL;
    echo "  12. Tampilkan Riwayat Pesan Berdasarkan Email" . PHP_EOL;
    echo "  13. Tampilkan Semua Pesan Kontak Masuk" . PHP_EOL;
    echo PHP_EOL;
    echo "   0. Keluar" . PHP_EOL;
    echo "----------------------------------------------------------" . PHP_EOL;

    $choice = prompt("Pilih nomor menu (0-13):");

    switch ($choice) {
        // --- MEDIA SERVICE ---
        case '1':
            echo PHP_EOL . "--- [MEDIA] DAFTAR MEDIA DI LIBRARY ---" . PHP_EOL;
            $mediaList = $mediaService->getAllMedia();
            if (empty($mediaList)) {
                echo "Belum ada media di library." . PHP_EOL;
            } else {
                foreach ($mediaList as $index => $item) {
                    $num = $index + 1;
                    $rating = $item['rating'] ?? 'N/A';
                    $episodes = $item['episodes'] ?? 'N/A';
                    echo " {$num}. [ID: {$item['id']}] {$item['title']} | Rating: {$rating} | Episodes: {$episodes} | Status: {$item['status']}" . PHP_EOL;
                }
            }
            break;

        case '2':
            echo PHP_EOL . "--- [MEDIA] DETAIL MEDIA ---" . PHP_EOL;
            $id = prompt("Masukkan ID Media:");
            try {
                $detail = $mediaService->getMediaDetail((int)$id);
                echo "  -> ID       : {$detail['id']}" . PHP_EOL;
                echo "  -> Judul    : {$detail['title']}" . PHP_EOL;
                echo "  -> Rating   : {$detail['rating']}" . PHP_EOL;
                echo "  -> Episodes : {$detail['episodes']}" . PHP_EOL;
                echo "  -> Status   : {$detail['status']}" . PHP_EOL;
                echo "  -> Poster   : {$detail['url_image']}" . PHP_EOL;
            } catch (Exception $e) {
                echo "  [Error] " . $e->getMessage() . PHP_EOL;
            }
            break;

        case '3':
            echo PHP_EOL . "--- [MEDIA] TAMBAH MEDIA BARU ---" . PHP_EOL;
            $title = prompt("Judul Media:");
            $urlImage = prompt("URL Poster/Gambar (opsional):");
            $rating = prompt("Rating (contoh: 88.5):");
            $episodes = prompt("Jumlah Episode (contoh: 12):");
            $status = prompt("Status (current/finished):");

            try {
                $newId = $mediaService->addMedia([
                    'title'     => $title,
                    'url_image' => $urlImage,
                    'rating'    => $rating !== '' ? (float)$rating : null,
                    'episodes'  => $episodes !== '' ? (int)$episodes : null,
                    'status'    => $status !== '' ? $status : 'current'
                ]);
                echo "  [Sukses] Media berhasil ditambahkan dengan ID: {$newId}" . PHP_EOL;
            } catch (Exception $e) {
                echo "  [Error] " . $e->getMessage() . PHP_EOL;
            }
            break;

        // --- AUTH SERVICE ---
        case '4':
            echo PHP_EOL . "--- [AUTH] REGISTRASI PENGGUNA ---" . PHP_EOL;
            $name = prompt("Nama:");
            $email = prompt("Email:");
            $password = prompt("Password (min 6 karakter):");

            try {
                $newUserId = $authService->register([
                    'name'     => $name,
                    'email'    => $email,
                    'password' => $password
                ]);
                echo "  [Sukses] Akun berhasil terdaftar dengan User ID: {$newUserId}" . PHP_EOL;
            } catch (Exception $e) {
                echo "  [Error] " . $e->getMessage() . PHP_EOL;
            }
            break;

        case '5':
            echo PHP_EOL . "--- [AUTH] LOGIN PENGGUNA ---" . PHP_EOL;
            $email = prompt("Email:");
            $password = prompt("Password:");

            try {
                $user = $authService->login($email, $password);
                $currentUser = $user;
                echo "  [Sukses] Login berhasil! Selamat datang, {$user['name']}." . PHP_EOL;
            } catch (Exception $e) {
                echo "  [Error] " . $e->getMessage() . PHP_EOL;
            }
            break;

        case '6':
            echo PHP_EOL . "--- [AUTH] LOGOUT PENGGUNA ---" . PHP_EOL;
            if ($currentUser === null) {
                echo "  Anda memang belum login." . PHP_EOL;
            } else {
                echo "  User {$currentUser['name']} berhasil logout." . PHP_EOL;
                $currentUser = null;
            }
            break;

        // --- USER SERVICE ---
        case '7':
            echo PHP_EOL . "--- [USER] PROFIL SAYA ---" . PHP_EOL;
            if ($currentUser === null) {
                echo "  [Peringatan] Anda harus login terlebih dahulu (Pilih menu 5)." . PHP_EOL;
            } else {
                try {
                    $profile = $userService->getUserProfileById((int)$currentUser['id']);
                    echo "  -> ID    : {$profile['id']}" . PHP_EOL;
                    echo "  -> Nama  : {$profile['name']}" . PHP_EOL;
                    echo "  -> Email : {$profile['email']}" . PHP_EOL;
                } catch (Exception $e) {
                    echo "  [Error] " . $e->getMessage() . PHP_EOL;
                }
            }
            break;

        case '8':
            echo PHP_EOL . "--- [USER] CARI PENGGUNA BERDASARKAN ID ---" . PHP_EOL;
            $uid = prompt("Masukkan User ID:");
            try {
                $profile = $userService->getUserProfileById((int)$uid);
                echo "  -> ID    : {$profile['id']}" . PHP_EOL;
                echo "  -> Nama  : {$profile['name']}" . PHP_EOL;
                echo "  -> Email : {$profile['email']}" . PHP_EOL;
            } catch (Exception $e) {
                echo "  [Error] " . $e->getMessage() . PHP_EOL;
            }
            break;

        case '9':
            echo PHP_EOL . "--- [USER] DAFTAR SEMUA PENGGUNA ---" . PHP_EOL;
            try {
                $allUsers = $userService->getUsers();
                if (empty($allUsers)) {
                    echo "  Belum ada pengguna terdaftar." . PHP_EOL;
                } else {
                    foreach ($allUsers as $u) {
                        echo "  - [ID: {$u['id']}] {$u['name']} ({$u['email']})" . PHP_EOL;
                    }
                }
            } catch (Exception $e) {
                echo "  [Error] " . $e->getMessage() . PHP_EOL;
            }
            break;

        // --- MESSAGE SERVICE ---
        case '10':
            echo PHP_EOL . "--- [MESSAGE] KIRIM PESAN FEEDBACK KONTAK ---" . PHP_EOL;
            $name = $currentUser ? $currentUser['name'] : prompt("Nama:");
            $email = $currentUser ? $currentUser['email'] : prompt("Email:");
            $detail = prompt("Pesan Feedback:");

            try {
                $msgId = $messageService->sendMessage([
                    'name'   => $name,
                    'email'  => $email,
                    'detail' => $detail
                ]);
                echo "  [Sukses] Pesan feedback tersimpan dengan ID: {$msgId}" . PHP_EOL;
            } catch (Exception $e) {
                echo "  [Error] " . $e->getMessage() . PHP_EOL;
            }
            break;

        case '11':
            echo PHP_EOL . "--- [MESSAGE] DETAIL PESAN BERDASARKAN ID ---" . PHP_EOL;
            $msgId = prompt("Masukkan ID Pesan:");
            try {
                $msg = $messageService->getMessageDetail((int)$msgId);
                echo "  -> ID         : {$msg['id']}" . PHP_EOL;
                echo "  -> Pengirim   : {$msg['name']} ({$msg['email']})" . PHP_EOL;
                echo "  -> Tanggal    : {$msg['created_at']}" . PHP_EOL;
                echo "  -> Pesan      : {$msg['detail']}" . PHP_EOL;
            } catch (Exception $e) {
                echo "  [Error] " . $e->getMessage() . PHP_EOL;
            }
            break;

        case '12':
            echo PHP_EOL . "--- [MESSAGE] RIWAYAT PESAN BERDASARKAN EMAIL ---" . PHP_EOL;
            $email = $currentUser ? $currentUser['email'] : prompt("Masukkan Email:");
            try {
                $history = $messageService->getMessagesByEmail($email);
                if (empty($history)) {
                    echo "  Belum ada pesan yang dikirim oleh email: {$email}" . PHP_EOL;
                } else {
                    foreach ($history as $idx => $m) {
                        $n = $idx + 1;
                        echo "  {$n}. [ID: {$m['id']} | {$m['created_at']}] \"{$m['detail']}\"" . PHP_EOL;
                    }
                }
            } catch (Exception $e) {
                echo "  [Error] " . $e->getMessage() . PHP_EOL;
            }
            break;

        case '13':
            echo PHP_EOL . "--- [MESSAGE] SEMUA PESAN KONTAK MASUK ---" . PHP_EOL;
            try {
                $allMessages = $messageService->getAllMessage();
                if (empty($allMessages)) {
                    echo "  Kotak masuk pesan masih kosong." . PHP_EOL;
                } else {
                    foreach ($allMessages as $m) {
                        echo "  - [ID: {$m['id']} | {$m['created_at']}] {$m['name']} ({$m['email']}): \"{$m['detail']}\"" . PHP_EOL;
                    }
                }
            } catch (Exception $e) {
                echo "  [Error] " . $e->getMessage() . PHP_EOL;
            }
            break;

        case '0':
            echo PHP_EOL . "Terima kasih telah menggunakan FlipPlay Engine CLI. Sampai jumpa!" . PHP_EOL;
            exit(0);

        default:
            echo "Pilihan tidak valid. Silakan pilih menu nomor 0 sampai 13." . PHP_EOL;
            break;
    }
}
