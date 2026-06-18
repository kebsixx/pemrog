<?php
declare(strict_types=1);

use App\Models\MahasiswaModel;
use App\Controllers\AuthController;
use App\Controllers\AdminController;

require_once __DIR__ . '/../app/Models/MahasiswaModel.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/AdminController.php';

$config = require __DIR__ . '/../config/database.php';

$dsn = sprintf(
    'pgsql:host=%s;port=%d;dbname=%s',
    $config['host'],
    (int) $config['port'],
    $config['dbname']
);

try {
    $pdo = new PDO(
        $dsn,
        $config['user'],
        $config['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo 'Database connection failed.';
    exit;
}

$model = new MahasiswaModel($pdo, $config['schema']);
$authController = new AuthController($model);
$adminController = new AdminController($model);

$route = $_GET['route'] ?? 'overview';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

switch ($route) {
    case 'login':
        if ($method === 'POST') {
            $authController->login();
        } else {
            $authController->showLogin();
        }
        break;
    case 'register':
        if ($method === 'POST') {
            $authController->register();
        } else {
            $authController->showRegister();
        }
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'profile':
        $adminController->profile();
        break;
    case 'mahasiswa':
        $adminController->mahasiswaList();
        break;
    case 'tasks':
        $adminController->tasks();
        break;
    case 'task-upload':
        if ($method === 'POST') {
            $adminController->uploadTask();
        } else {
            header('Location: index.php?route=tasks');
            exit;
        }
        break;
    case 'task-download':
        $adminController->downloadTask();
        break;
    case 'overview':
    default:
        $adminController->overview();
        break;
}
