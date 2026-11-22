<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/utils/request.php';
require_once __DIR__ . '/utils/response.php';
require_once __DIR__ . '/utils/handler.php';

require_once __DIR__ . '/controller/mediaController.php';
require_once __DIR__ . '/controller/messageController.php';
require_once __DIR__ . '/controller/userController.php';
require_once __DIR__ . '/controller/authController.php';

use App\Utils\Request;
use App\Utils\Response;
use App\Utils\Handler;
use App\Controller\MediaController;
use App\Controller\MessageController;
use App\Controller\UserController;
use App\Controller\AuthController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// ponytail: normalisasi path URL
$path = preg_replace('#^.*index\.php#', '', $uri);
$path = rtrim($path, '/');
if (empty($path)) {
    $path = '/';
}

$mediaCtrl   = new MediaController();
$messageCtrl = new MessageController();
$userCtrl    = new UserController();
$authCtrl    = new AuthController();

Handler::run(function () use ($path, $method, $mediaCtrl, $messageCtrl, $userCtrl, $authCtrl) {
    match (true) {
        // Media Routes
        $path === '/media' && $method === 'GET' && Request::query('id') !== null => $mediaCtrl->getDetail(),
        $path === '/media' && $method === 'GET'                                 => $mediaCtrl->getAll(),
        $path === '/media' && $method === 'POST'                                => $mediaCtrl->create(),

        // Message / Contact Routes
        $path === '/contact'         && $method === 'POST'                              => $messageCtrl->send(),
        $path === '/contact'         && $method === 'GET' && Request::query('id')       => $messageCtrl->getDetail(),
        $path === '/contact/history' && $method === 'GET' && Request::query('email')    => $messageCtrl->getHistoryByEmail(),
        $path === '/contact'         && $method === 'GET'                               => $messageCtrl->getAllMessage(),

        // User Routes
        $path === '/users' && $method === 'GET' && Request::query('id')                 => $userCtrl->getProfile(),
        $path === '/users' && $method === 'GET'                                         => $userCtrl->getAllUsers(),

        // Auth Routes
        $path === '/auth/register' && $method === 'POST' => $authCtrl->register(),
        $path === '/auth/login'    && $method === 'POST' => $authCtrl->login(),

        default => Response::error("Route [{$method}] {$path} tidak ditemukan.", null, 404),
    };
});
