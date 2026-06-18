<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\MahasiswaModel;

class AdminController
{
    private MahasiswaModel $model;

    public function __construct(MahasiswaModel $model)
    {
        $this->model = $model;
    }

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function requireLogin(): void
    {
        $this->startSession();

        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }
    }

    public function overview(): void
    {
        $this->requireLogin();
        $pageTitle = 'Overview';
        $activeRoute = 'overview';
        $username = $_SESSION['username'] ?? '';
        $rememberedUsername = $_COOKIE['last_login_username'] ?? '';
        $lastLoginAt = $_COOKIE['last_login_at'] ?? '';

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/admin/overview.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function profile(): void
    {
        $this->requireLogin();
        $pageTitle = 'Profile';
        $activeRoute = 'profile';
        $id = (int) $_SESSION['user_id'];
        $profile = $this->model->getProfile($id);

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/admin/profile.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function mahasiswaList(): void
    {
        $this->requireLogin();
        $pageTitle = 'Data Mahasiswa';
        $activeRoute = 'mahasiswa';
        $rows = $this->model->getAllMahasiswa();

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/admin/mahasiswa.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function tasks(): void
    {
        $this->requireLogin();
        $pageTitle = 'Data Tugas';
        $activeRoute = 'tasks';

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/admin/tasks.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }
}
