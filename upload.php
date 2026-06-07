<?php
if (isset($_FILES['fileToUpload'])) {
    $file_name = $_FILES['fileToUpload']['name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];

    if ($file_type == "image/jpeg" || $file_type == "image/png") {
        move_uploaded_file($file_tmp, "uploads/" . $file_name);
        echo "File berhasil diunggah.";
    } else {
        echo "Hanya file JPEG dan PNG yang diperbolehkan!";
    }
}
