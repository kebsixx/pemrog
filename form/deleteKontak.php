<?php
include 'connection.php';

// Mengambil ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query hapus data berdasarkan ID
    $sql = "DELETE FROM Kontak WHERE ID = $id";

    try {
        $db_conn->query($sql);
        // Redirect kembali ke halaman utama setelah berhasil
        header("location:index.php");
    } catch (PDOException $e) {
        die("Gagal menghapus data: " . $e->getMessage());
    }
} else {
    header("location:index.php");
}
