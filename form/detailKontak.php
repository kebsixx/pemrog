<!DOCTYPE html>
<html>

<head>
    <title>Detail Kontak</title>
</head>

<body>
    <h2>Detail Kontak Bisnis</h2>
    <a href="index.php">KEMBALI KE DAFTAR</a>
    <br><br>

    <?php
    include 'connection.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // Query untuk mengambil satu data spesifik
        $sql = "SELECT * FROM Kontak WHERE ID = $id";
        $result = $db_conn->query($sql);

        if ($row = $result->fetch()) {
    ?>
            <table border="0" cellpadding="5">
                <tr>
                    <td><strong>ID Kontak</strong></td>
                    <td>: <?php echo $row[0]; ?></td>
                </tr>
                <tr>
                    <td><strong>Nama Depan</strong></td>
                    <td>: <?php echo $row[2]; ?></td>
                </tr>
                <tr>
                    <td><strong>Nama Belakang</strong></td>
                    <td>: <?php echo $row[1]; ?></td>
                </tr>
                <tr>
                    <td><strong>Alamat Email</strong></td>
                    <td>: <?php echo $row[3]; ?></td>
                </tr>
            </table>
            <br>
            <a href="editKontak.php?id=<?php echo $row[0]; ?>">Edit Data Ini</a>
    <?php
        } else {
            echo "Data tidak ditemukan.";
        }
    }
    ?>
</body>

</html>