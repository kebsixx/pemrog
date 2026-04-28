<?php
$host = "localhost";
$port = "5432";
$dbname = "kampusdb";
$user = "mahasiswa";
$pass = "password123";

try {
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $db_conn = new PDO($dsn, $user, $pass);
    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
