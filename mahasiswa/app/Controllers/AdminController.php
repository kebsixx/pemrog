<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\MahasiswaModel;

class AdminController
{
    private const AVATAR_DIR = __DIR__ . '/../../storage/avatars';
    private const MAX_UPLOAD_SIZE = 2097152;
    private const DEFAULT_AVATAR = 'assets/img/default-avatar.jpg';

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

    private function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message,
        ];
    }

    private function pullFlash(): ?array
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        return is_array($flash) ? $flash : null;
    }

    public function overview(): void
    {
        $this->requireLogin();
        $pageTitle = 'Overview';
        $activeRoute = 'overview';
        $username = $_SESSION['username'] ?? '';
        $rememberedUsername = $_COOKIE['last_login_username'] ?? '';
        $lastLoginAt = $_COOKIE['last_login_at'] ?? '';
        $profile = $this->model->getProfile((int) $_SESSION['user_id']);
        $avatarUrl = $this->resolveAvatarUrl($profile);

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
        $flash = $this->pullFlash();
        $avatarUrl = $this->resolveAvatarUrl($profile);

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
        $pageTitle = 'Upload Avatar';
        $activeRoute = 'tasks';
        $flash = $this->pullFlash();
        $avatar = $this->model->getAvatarByUser((int) $_SESSION['user_id']);
        $avatarUrl = $this->resolveAvatarUrl($avatar);

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/admin/tasks.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function uploadTask(): void
    {
        $this->requireLogin();
        $file = $_FILES['berkas'] ?? null;

        if (!is_array($file)) {
            $this->setFlash('error', 'File avatar wajib dipilih.');
            header('Location: index.php?route=tasks');
            exit;
        }

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $this->setFlash('error', 'Proses upload gagal. Pilih file yang valid lalu coba lagi.');
            header('Location: index.php?route=tasks');
            exit;
        }

        if (($file['size'] ?? 0) > self::MAX_UPLOAD_SIZE) {
            $this->setFlash('error', 'Ukuran file maksimal 2 MB.');
            header('Location: index.php?route=tasks');
            exit;
        }

        $originalName = (string) ($file['name'] ?? '');
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if ($originalName === '' || !in_array($extension, $allowed, true)) {
            $this->setFlash('error', 'Format avatar tidak didukung. Gunakan JPG, JPEG, PNG, atau GIF.');
            header('Location: index.php?route=tasks');
            exit;
        }

        if (!is_dir(self::AVATAR_DIR) && !mkdir(self::AVATAR_DIR, 0777, true) && !is_dir(self::AVATAR_DIR)) {
            $this->setFlash('error', 'Folder upload tidak dapat dibuat.');
            header('Location: index.php?route=tasks');
            exit;
        }

        $currentAvatar = $this->model->getAvatarByUser((int) $_SESSION['user_id']);
        $storedName = sprintf(
            'avatar_%d_%s.%s',
            (int) $_SESSION['user_id'],
            bin2hex(random_bytes(8)),
            $extension
        );
        $targetPath = self::AVATAR_DIR . DIRECTORY_SEPARATOR . $storedName;

        if (!move_uploaded_file((string) $file['tmp_name'], $targetPath)) {
            $this->setFlash('error', 'File gagal disimpan ke server.');
            header('Location: index.php?route=tasks');
            exit;
        }

        $saved = $this->model->saveAvatar([
            'id' => (int) $_SESSION['user_id'],
            'avatar_nama_asli' => $originalName,
            'avatar_nama_file' => $storedName,
            'avatar_ukuran_file' => (int) $file['size'],
            'avatar_tipe_file' => (string) ($file['type'] ?? 'application/octet-stream'),
        ]);

        if (!$saved) {
            @unlink($targetPath);
            $this->setFlash('error', 'Data avatar gagal disimpan ke database.');
            header('Location: index.php?route=tasks');
            exit;
        }

        if (!empty($currentAvatar['avatar_nama_file'])) {
            $oldPath = self::AVATAR_DIR . DIRECTORY_SEPARATOR . $currentAvatar['avatar_nama_file'];
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
        }

        $this->setFlash('success', 'Avatar berhasil diupload.');
        header('Location: index.php?route=tasks');
        exit;
    }

    public function downloadTask(): void
    {
        $this->requireLogin();

        $avatar = $this->model->getAvatarByUser((int) $_SESSION['user_id']);
        if (empty($avatar['avatar_nama_file'])) {
            $this->setFlash('error', 'Avatar belum diupload.');
            header('Location: index.php?route=tasks');
            exit;
        }

        $path = self::AVATAR_DIR . DIRECTORY_SEPARATOR . $avatar['avatar_nama_file'];
        if (!is_file($path)) {
            $this->setFlash('error', 'File fisik tidak ditemukan di server.');
            header('Location: index.php?route=tasks');
            exit;
        }

        header('Content-Description: File Transfer');
        header('Content-Type: ' . ($avatar['avatar_tipe_file'] ?: 'application/octet-stream'));
        header('Content-Disposition: attachment; filename="' . basename((string) $avatar['avatar_nama_asli']) . '"');
        header('Content-Length: ' . (string) filesize($path));
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: public');
        readfile($path);
        exit;
    }

    private function resolveAvatarUrl(?array $profile): string
    {
        if (!empty($profile['avatar_nama_file'])) {
            return '../storage/avatars/' . rawurlencode((string) $profile['avatar_nama_file']);
        }

        return self::DEFAULT_AVATAR;
    }
}
