<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\MahasiswaModel;

class AuthController
{
    private const COOKIE_USERNAME = 'last_login_username';
    private const COOKIE_LOGIN_AT = 'last_login_at';
    private const COOKIE_LIFETIME = 604800;

    private MahasiswaModel $model;

    public function __construct(MahasiswaModel $model)
    {
        $this->model = $model;
        $this->startSession();
    }

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function showLogin(string $error = ''): void
    {
        $pageTitle = 'Login';
        $rememberedUsername = $_COOKIE[self::COOKIE_USERNAME] ?? '';
        $lastLoginAt = $_COOKIE[self::COOKIE_LOGIN_AT] ?? '';
        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/auth/login.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function showRegister(string $error = '', array $old = []): void
    {
        $pageTitle = 'Register';
        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/auth/register.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function login(): void
    {
        $user = trim($_POST['username'] ?? '');
        $pass = $_POST['password'] ?? '';

        if ($user === '' || $pass === '') {
            $this->showLogin('Username dan password wajib diisi.');
            return;
        }

        $row = $this->model->login($user, $pass);
        if (!$row) {
            $this->showLogin('Login gagal. Username atau password salah.');
            return;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $row['id'];
        $_SESSION['username'] = $row['username'];
        $this->storeLoginCookies($row['username']);

        header('Location: index.php?route=overview');
        exit;
    }

    public function logout(): void
    {
        $this->startSession();
        session_unset();
        session_destroy();

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 3600, $params['path'], $params['domain'], (bool) $params['secure'], (bool) $params['httponly']);
        }

        header('Location: index.php?route=login');
        exit;
    }

    public function register(): void
    {
        $data = [
            'nama' => trim($_POST['nama'] ?? ''),
            'nrp' => trim($_POST['nrp'] ?? ''),
            'alamat' => trim($_POST['alamat'] ?? ''),
            'ttl' => trim($_POST['ttl'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'nohp' => trim($_POST['nohp'] ?? ''),
            'username' => trim($_POST['username'] ?? ''),
            'password' => $_POST['password'] ?? '',
        ];

        foreach (['nama', 'nrp', 'alamat', 'ttl', 'email', 'nohp', 'username', 'password'] as $field) {
            if ($data[$field] === '') {
                $this->showRegister('Semua field wajib diisi.', $data);
                return;
            }
        }

        $maxLengths = [
            'nama' => 100,
            'nrp' => 15,
            'alamat' => 200,
            'ttl' => 50,
            'email' => 50,
            'nohp' => 50,
            'username' => 50,
        ];

        foreach ($maxLengths as $field => $max) {
            if (strlen($data[$field]) > $max) {
                $this->showRegister("Field {$field} maksimal {$max} karakter.", $data);
                return;
            }
        }

        if ($this->model->isUsernameTaken($data['username'])) {
            $this->showRegister('Username sudah digunakan.', $data);
            return;
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        if (strlen($data['password']) > 255) {
            $this->showRegister('Kolom password di database terlalu pendek. Ubah menjadi varchar(255) terlebih dulu.', $data);
            return;
        }

        if (!$this->model->register($data)) {
            $this->showRegister('Registrasi gagal. Coba lagi.', $data);
            return;
        }

        header('Location: index.php?route=login');
        exit;
    }

    private function storeLoginCookies(string $username): void
    {
        $expires = time() + self::COOKIE_LIFETIME;
        $path = '/';

        setcookie(self::COOKIE_USERNAME, $username, $expires, $path, '', false, true);
        setcookie(self::COOKIE_LOGIN_AT, date('Y-m-d H:i:s'), $expires, $path, '', false, true);
    }
}
