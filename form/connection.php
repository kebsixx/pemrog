<?php
$db = 'C:\laragon\www\pw\form\kontak.accdb';

if (!file_exists($db)) {
    die("Error: File database tidak ditemukan.");
}

try {
    $db_conn = new PDO("odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$db;");
    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
