# Cheat Sheet Pemrograman Web (MS Access & PostgreSQL)

## 1. Sintaks & Struktur Kontrol PHP
```php
// Tipe Data & Variabel
$nama = "Budi"; $umur = 20;

// Percabangan & Perulangan
if ($umur >= 18) { /* ... */ }
foreach ($items as $key => $val) { /* ... */ }

// Array Asosiatif (Sering untuk Database)
$mhs = ["nrp" => "001", "nama" => "Andi"];
echo $mhs['nama'];
```

## 2. Koneksi Database (PDO) - Tanpa MySQL
### A. MS Access (ODBC)
```php
$db = 'D:\Kampus\PW\kontak.accdb';
$dsn = "odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)}; DBQ=$db;";
$conn = new PDO($dsn, "", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

### B. PostgreSQL
```php
$dsn = "pgsql:host=localhost;port=5432;dbname=my_db;";
$conn = new PDO($dsn, "postgres", "password");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```

## 3. Query Database (CRUD dengan PDO)
### Read (SELECT)
```php
$stmt = $conn->query("SELECT * FROM Kontak");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $row['NamaDepan'];
}
```

### Write (Prepared Statement - Aman dari SQL Injection)
```php
// INSERT
$stmt = $conn->prepare("INSERT INTO Kontak (Nama, Email) VALUES (:nama, :email)");
$stmt->execute([':nama' => $nama, ':email' => $email]);

// UPDATE
$stmt = $conn->prepare("UPDATE Kontak SET Nama = :nama WHERE ID = :id");
$stmt->execute([':nama' => $nama, ':id' => $id]);

// DELETE
$stmt = $conn->prepare("DELETE FROM Kontak WHERE ID = :id");
$stmt->execute([':id' => $id]);
```

## 4. Form Handling (GET & POST)
```php
// Sanitasi dasar (Cegah XSS)
$input = htmlspecialchars($_POST['input_name'], ENT_QUOTES, 'UTF-8');
```

## 5. OOP PHP
```php
class User {
    private $id;
    public $name;
    
    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
}
$user = new User(1, "Budi");
```

## 6. Session & Cookies (Autentikasi)
### Session (Server-side, Aman untuk Login)
```php
session_start(); // Wajib di baris paling atas sebelum tag HTML

// Set & Cek
$_SESSION['login'] = true;
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }

// Hapus
session_unset(); session_destroy();
```

### Cookies (Client-side)
```php
setcookie("theme", "dark", time() + 3600, "/"); // Set 1 jam
$theme = $_COOKIE['theme'] ?? 'default'; // Baca
setcookie("theme", "", time() - 3600, "/"); // Hapus
```

## 7. Upload File
* **HTML**: Form harus menggunakan `method="post"` dan `enctype="multipart/form-data"`.
```php
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (in_array($ext, ['jpg', 'png', 'pdf']) && $file['size'] < 2000000) {
        $dest = "uploads/" . uniqid() . "." . $ext;
        move_uploaded_file($file['tmp_name'], $dest);
    }
}
```
