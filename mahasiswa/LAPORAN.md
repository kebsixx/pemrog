# Laporan Pengembangan Aplikasi Mahasiswa (MVC Sederhana)

Laporan ini merinci struktur dan implementasi fitur-fitur utama dalam aplikasi manajemen data mahasiswa yang dibangun menggunakan arsitektur **Model-View-Controller (MVC)** sederhana.

## 1. Struktur Proyek (MVC)

Proyek ini diorganisir menggunakan pola MVC untuk memisahkan logika bisnis, presentasi, dan akses data.

- **`app/Models/`**: Berisi `MahasiswaModel.php` yang menangani semua interaksi langsung dengan database PostgreSQL menggunakan PDO.
- **`app/Views/`**: Berisi template tampilan (UI).
    - `auth/`: Halaman Login dan Register.
    - `admin/`: Halaman Overview, Profile, dan Data Mahasiswa.
    - `layout/`: Header dan Footer yang digunakan secara konsisten di seluruh aplikasi.
- **`app/Controllers/`**: Bertindak sebagai perantara.
    - `AuthController.php`: Menangani proses autentikasi (Login, Register, Logout).
    - `AdminController.php`: Menangani halaman setelah login (Overview, Profile, List Mahasiswa).
- **`public/index.php`**: **Front Controller**. Semua request masuk melalui file ini, yang kemudian menentukan controller mana yang akan dijalankan berdasarkan parameter `route`.
- **`config/database.php`**: Menyimpan konfigurasi koneksi database.

---

## 2. Implementasi Modul Tugas

Sesuai dengan instruksi tugas, berikut adalah rincian implementasi untuk setiap halaman:

### A. Modul Login
- **Controller**: `AuthController::showLogin()` (menampilkan form) dan `AuthController::login()` (proses validasi).
- **Model**: `MahasiswaModel::login()` mencocokkan username dan memverifikasi hash password.
- **View**: `app/Views/auth/login.php`.
- **Fitur**: Melakukan pengecekan `password_verify` terhadap hash BCrypt di database. Jika berhasil, ID user disimpan dalam `$_SESSION`.

### B. Modul Register
- **Controller**: `AuthController::register()`.
- **Model**: `MahasiswaModel::register()` dan `MahasiswaModel::isUsernameTaken()`.
- **View**: `app/Views/auth/register.php`.
- **Fitur**: Validasi input (wajib diisi, panjang karakter), pengecekan username unik, dan hashing password sebelum disimpan ke database.

### C. Modul Overview
- **Controller**: `AdminController::overview()`.
- **View**: `app/Views/admin/overview.php`.
- **Fitur**: Menampilkan ringkasan informasi atau selamat datang setelah user berhasil login. Dilengkapi dengan pengecekan `requireLogin()` untuk memastikan hanya user terautentikasi yang bisa mengakses.

### D. Modul Profile
- **Controller**: `AdminController::profile()`.
- **Model**: `MahasiswaModel::getProfile($id)`.
- **View**: `app/Views/admin/profile.php`.
- **Fitur**: Menampilkan data detail profil mahasiswa berdasarkan ID yang sedang login atau ID yang dikirim melalui parameter URL.

### E. Modul Data Mahasiswa
- **Controller**: `AdminController::mahasiswaList()`.
- **Model**: `MahasiswaModel::getAllMahasiswa()`.
- **View**: `app/Views/admin/mahasiswa.php`.
- **Fitur**: Mengambil daftar seluruh mahasiswa yang terdaftar di database dan menampilkannya dalam format tabel.

---

## 3. Detail Teknis

- **Database**: PostgreSQL dengan skema khusus (`mahasiswa`).
- **Autentikasi**: Menggunakan PHP Session standar.
- **Styling**: CSS eksternal di `public/assets/css/style.css` untuk memastikan tampilan yang rapi dan konsisten.
- **Keamanan**: Penggunaan `password_hash()` dan `password_verify()` untuk manajemen password, serta `PDO prepared statements` untuk mencegah SQL Injection.
