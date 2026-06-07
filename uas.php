<?php 
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    try {
        $dsn = "pgsql:host=localhost;port=5432;dbname=db_user;";
        $db_conn = new PDO($dsn, "postgres", "password");
        $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Koneksi database gagal: " . $e->getMessage();
        exit();
    }

    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     $nrp = $_POST['nrp'];
    //     $nama = $_POST['nama'];

    //     if (empty($nrp) || empty($nama)) {
    //         echo "NRP dan Nama tidak boleh kosong.";
    //     } else if (!is_numeric($nrp)) {
    //         echo "NRP harus berupa angka.";
    //     } else {
    //         try {
    //             $dsn = "pgsql:host=localhost;port=5432;dbname=db_user;";
    //             $db_conn = new PDO($dsn, "postgres", "password");
    //             $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //             $query = "INSERT INTO mahasiswa (nrp, nama) VALUES (:nrp, :nama)";
    //             $db_conn->prepare($query);

    //             header("Location: uas.php");
    //             exit();
    //         } catch (PDOException $e) {
    //             echo "Koneksi database gagal: " . $e->getMessage();
    //             exit();
    //         }
    //     }
    // }
?>