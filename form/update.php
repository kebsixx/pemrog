<?php
// koneksi database
include 'connection.php';
// menangkap data yang di kirim dari form
$ID = $_POST['ID'];
$NamaDepan = $_POST['NamaDepan'];
$NamaBelakang = $_POST['NamaBelakang'];
$AlamatEmail = $_POST['AlamatEmail'];
//echo $NamaBelakang;
// update data ke database
$sql = "UPDATE Kontak Set NamaDepan='$NamaDepan', NamaBelakang='$NamaBelakang',
AlamatEmail='$AlamatEmail' WHERE ID = $ID";
$result = $db_conn->query($sql);
// mengalihkan halaman kembali ke index.php
header("location:index.php");
