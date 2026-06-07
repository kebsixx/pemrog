<?php
try {
    $dsn = "pgsql:host=localhost;port=5432;dbname=db_user;";
    $db_conn = new PDO($dsn, "postgres", "password");
    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
    exit();
}
