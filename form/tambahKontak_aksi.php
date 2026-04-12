<?php
include 'connection.php';
$sql = "INSERT INTO Kontak (NamaDepan, NamaBelakang, AlamatEmail) 
        VALUES ('" . $_POST['NamaDepan'] . "', '" . $_POST['NamaBelakang'] . "', '" . $_POST['AlamatEmail'] . "')";
$db_conn->query($sql);
header("location:index.php");
