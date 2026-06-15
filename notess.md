# Catatan Persiapan Post Test - Pemrograman Web

Catatan ini dirancang khusus untuk persiapan post-test dengan fokus pada materi yang diajarkan di kelas Teori dan Praktikum Pemrograman Web, menggunakan **Microsoft Access** dan **PostgreSQL** sebagai sistem basis data (MySQL tidak digunakan/diperbolehkan).

---

## Daftar Isi
1. [Webserver & Protokol HTTP](#1-webserver--protokol-http)
2. [Sintaks Dasar & Struktur Kontrol PHP](#2-sintaks-dasar--struktur-kontrol-php)
3. [Array & Manipulasi String](#3-array--manipulasi-string)
4. [Form Handling (GET & POST)](#4-form-handling-get--post)
5. [Object-Oriented Programming (OOP) PHP](#5-object-oriented-programming-oop-php)
6. [Koneksi & Operasi Database (Access & PostgreSQL)](#6-koneksi--operasi-database-access--postgresql)
7. [Session & Cookies (Autentikasi)](#7-session--cookies-autentikasi)
8. [Upload & Download File](#8-upload--download-file)

---

## 1. Webserver & Protokol HTTP

### Konsep Client-Server
* **Client (Browser):** Mengirimkan HTTP Request ke server.
* **Server (Webserver seperti Apache):** Memproses request, mengeksekusi kode PHP, dan mengirimkan HTTP Response kembali ke client dalam bentuk HTML/CSS/JS.

### Cara Kerja PHP
* PHP adalah bahasa *Server-Side Scripting*. Artinya, kode PHP dieksekusi sepenuhnya di server sebelum hasilnya dikirimkan ke browser. Browser tidak pernah melihat kode PHP asli, hanya hasil HTML-nya.

---

## 2. Sintaks Dasar & Struktur Kontrol PHP

### Sintaks Dasar
Sintaks PHP harus diapit oleh tag pembuka dan penutup:
```php
<?php
// Ini komentar satu baris
/* Ini komentar
   multiline */
echo "Halo Dunia!"; // Menampilkan output ke layar
?>
```

### Variabel & Tipe Data
* Dideklarasikan dengan tanda dollar (`$`), bersifat *loosely typed* (tipe data otomatis ditentukan berdasarkan nilai).
* Contoh: `$nama = "Budi";` (String), `$umur = 20;` (Integer), `$ipk = 3.85;` (Float), `$is_active = true;` (Boolean).

### Struktur Kontrol
1. **Percabangan (`if`, `else`, `elseif`, `switch`):**
   ```php
   if ($nilai >= 80) {
       $grade = "A";
   } elseif ($nilai >= 70) {
       $grade = "B";
   } else {
       $grade = "C";
   }
   ```
2. **Perulangan (`for`, `while`, `do-while`, `foreach`):**
   ```php
   // Foreach sangat penting untuk iterasi array
   $buah = ["Apel", "Jeruk", "Mangga"];
   foreach ($buah as $b) {
       echo $b . " ";
   }
   ```

---

## 3. Array & Manipulasi String

### Array di PHP
Ada dua jenis array yang sering keluar di ujian/praktikum:
1. **Indexed Array (Array Terindeks):**
   ```php
   $mhs = ["Rudi", "Siti", "Andi"];
   echo $mhs[0]; // Output: Rudi
   ```
2. **Associative Array (Array Asosiatif):** Menggunakan key kustom berupa string (sangat penting saat mengambil data dari database).
   ```php
   $mhs = [
       "nrp" => "3125600001",
       "nama" => "Rudi",
       "jurusan" => "Teknik Informatika"
   ];
   echo $mhs["nama"]; // Output: Rudi
   ```

### Manipulasi String yang Sering Digunakan
* `strlen($str)`: Mendapatkan panjang string.
* `explode($delimiter, $str)`: Memecah string menjadi array berdasarkan delimiter.
* `implode($glue, $array)`: Menggabungkan elemen array menjadi string.
* `substr($str, $start, $length)`: Mengambil sebagian string.
* `trim($str)`: Menghapus spasi di awal/akhir string.

---

## 4. Form Handling (GET & POST)

### Perbedaan GET vs POST

| Karakteristik | GET | POST |
| :--- | :--- | :--- |
| **Pengiriman Data** | Melalui URL query string (`?key=val`) | Melalui HTTP Request Body (tidak terlihat di URL) |
| **Kapasitas** | Terbatas (~2048 karakter) | Tidak terbatas secara teori |
| **Keamanan** | Tidak aman untuk data sensitif (password/pin) | Lebih aman (tapi tetap butuh HTTPS) |
| **Penggunaan** | Pencarian, filter, navigasi halaman | Submit form, login, insert/update data |

### Menangkap Data Form di PHP
```php
// Menggunakan GET
$nama = $_GET['nama'];

// Menggunakan POST
$password = $_POST['password'];
```

### Validasi & Keamanan Dasar (Sanitasi)
Untuk menghindari celah keamanan seperti XSS (Cross-Site Scripting), gunakan:
```php
$nama = htmlspecialchars($_POST['nama'], ENT_QUOTES, 'UTF-8');
```

---

## 5. Object-Oriented Programming (OOP) PHP

OOP sering digunakan untuk menyusun kelas koneksi database atau manajemen model data.

### Konsep Dasar: Class, Object, Property, dan Method
```php
class Mahasiswa {
    // Properties
    public $nama;
    private $nrp; // Hanya bisa diakses di dalam class ini

    // Constructor (dijalankan otomatis saat objek dibuat)
    public function __construct($nama, $nrp) {
        $this->nama = $nama;
        $this->nrp = $nrp;
    }

    // Method
    public function tampilkanData() {
        return "NRP: " . $this->nrp . ", Nama: " . $this->nama;
    }
}

// Instansiasi Objek
$mhs1 = new Mahasiswa("Andi", "3125600002");
echo $mhs1->tampilkanData();
```

### Access Modifiers
* `public`: Dapat diakses dari mana saja (di dalam/luar class).
* `protected`: Hanya dapat diakses di dalam class itu sendiri dan class turunannya (*child class*).
* `private`: Hanya dapat diakses di dalam class itu sendiri.

---

## 6. Koneksi & Operasi Database (Access & PostgreSQL)

> [!IMPORTANT]
> Di mata kuliah ini, **MySQL tidak diperbolehkan**. Database yang digunakan adalah **MS Access** dan **PostgreSQL** dengan menggunakan driver **PDO (PHP Data Objects)**.

### A. Microsoft Access (Menggunakan PDO ODBC)
Untuk menghubungkan PHP ke Microsoft Access, pastikan ekstensi `extension=odbc` dan `extension=pdo_odbc` diaktifkan di `php.ini`.

#### 1. Kelas Koneksi (connection.php)
```php
<?php
// Path ke file database MS Access (.accdb)
$db_path = 'D:\Kampus\PW\Materi\Praktikum\kontak.accdb';

if (!file_exists($db_path)) {
    die("Error: File database Access tidak ditemukan!");
}

try {
    // DSN ODBC untuk Microsoft Access Driver
    $dsn = "odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)}; DBQ=$db_path;";
    $db_conn = new PDO($dsn, "", "");
    
    // Set error mode ke Exception
    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
```

#### 2. Query SELECT (Read Data)
```php
$sql = "SELECT ID, NamaDepan, NamaBelakang, AlamatEmail FROM Kontak";
$result = $db_conn->query($sql);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "ID: " . $row['ID'] . " - Nama: " . $row['NamaDepan'] . " " . $row['NamaBelakang'] . "<br>";
}
```

#### 3. Query INSERT (Prepared Statements untuk Keamanan SQL Injection)
```php
$sql = "INSERT INTO Kontak (NamaDepan, NamaBelakang, AlamatEmail) VALUES (:depan, :belakang, :email)";
$stmt = $db_conn->prepare($sql);

$stmt->execute([
    ':depan' => $namaDepan,
    ':belakang' => $namaBelakang,
    ':email' => $alamatEmail
]);
```

---

### B. PostgreSQL (Menggunakan PDO PGSQL)
Pastikan `extension=pdo_pgsql` diaktifkan di `php.ini`.

#### 1. Kelas Koneksi
```php
<?php
$host = "localhost";
$port = "5432";
$dbname = "nama_database";
$user = "postgres";
$password = "password_postgres";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $db_conn = new PDO($dsn, $user, $password);
    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi PostgreSQL gagal: " . $e->getMessage());
}
?>
```

#### 2. Query CRUD PostgreSQL (Sama seperti Access setelah koneksi terbentuk)
```php
// UPDATE Contoh
$sql = "UPDATE Kontak SET NamaDepan = :nama WHERE ID = :id";
$stmt = $db_conn->prepare($sql);
$stmt->execute([
    ':nama' => 'Panji',
    ':id' => 4
]);

// DELETE Contoh
$sql = "DELETE FROM Kontak WHERE ID = :id";
$stmt = $db_conn->prepare($sql);
$stmt->execute([':id' => $id]);
```

---

## 7. Session & Cookies (Autentikasi)

### Cookies
* Disimpan di **sisi client (browser)**.
* Cocok untuk data tidak sensitif (seperti preferensi bahasa atau tema).
```php
// Membuat Cookie (berlaku selama 1 jam)
setcookie("user_theme", "dark", time() + 3600, "/");

// Membaca Cookie
if (isset($_COOKIE['user_theme'])) {
    echo "Tema terpilih: " . $_COOKIE['user_theme'];
}

// Menghapus Cookie (set time mundur)
setcookie("user_theme", "", time() - 3600, "/");
```

### Session
* Disimpan di **sisi server**. Hanya ID session (`PHPSESSID`) yang disimpan di browser client.
* Sangat aman, digunakan untuk **Sistem Login**.
```php
// Wajib diletakkan di baris paling atas sebelum ada output HTML
session_start();

// Set Session setelah login berhasil
$_SESSION['username'] = $username;
$_SESSION['is_logged_in'] = true;

// Proteksi Halaman (Cek Login)
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Logout (Hapus Session)
session_unset();
session_destroy();
header("Location: login.php");
exit();
```

---

## 8. Upload & Download File

### Form Upload File (HTML)
* Wajib menambahkan atribut `enctype="multipart/form-data"` pada tag `<form>` dan metode harus `POST`.
```html
<form action="upload.php" method="post" enctype="multipart/form-data">
    Pilih File: <input type="file" name="dokumen">
    <input type="submit" value="Upload">
</form>
```

### Menangani Upload File di PHP
Menggunakan variabel superglobal `$_FILES`.
```php
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['dokumen'])) {
    $file = $_FILES['dokumen'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // Validasi Ekstensi File
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExt = ['pdf', 'doc', 'docx', 'jpg', 'png'];

    if (in_array($fileExt, $allowedExt)) {
        if ($fileError === 0) {
            if ($fileSize < 5000000) { // Limit 5MB
                // Buat nama baru agar unik
                $newFileName = uniqid('', true) . "." . $fileExt;
                $destination = 'uploads/' . $newFileName;
                
                if (move_uploaded_file($fileTmpName, $destination)) {
                    echo "File berhasil diunggah!";
                } else {
                    echo "Gagal memindahkan file.";
                }
            } else {
                echo "Ukuran file terlalu besar!";
            }
        } else {
            echo "Terjadi error saat upload.";
        }
    } else {
        echo "Tipe file tidak diizinkan!";
    }
}
?>
```
