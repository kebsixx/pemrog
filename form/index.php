<!DOCTYPE html>
<html>

<head>
    <title>Kontak Bisnis</title>
</head>

<body>
    <h2>Kontak Bisnis - MS Access</h2>
    <br />
    <a href="tambahKontak.php">Tambah Kontak</a>
    <br />
    <table border='1'>
        <tr>
            <th>No </th>
            <th>Nama Depan</th>
            <th>Nama Belakang</th>
            <th>Alamat Email</th>
            <th>Aksi</th>
        </tr>
        <?php
        include 'connection.php';
        // $update = "UPDATE Kontak SET NamaDepan = 'Panji' WHERE ID = 4";
        // $hasil = $db_conn->query($update);
        $no = 1;
        $sql = "SELECT * FROM kontak";
        $result = $db_conn->query($sql);
        while ($row = $result->fetch()) {
        ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $row[2] ?></td>
                <td><?php echo $row[1] ?></td>
                <td><?php echo $row[3] ?></td>
                <td>
                    <a href="editKontak.php?id=<?php echo $row[0] ?>">Edit</a>
                    <a href="deleteKontak.php?id=<?php echo $row[0] ?>">Hapus</a>
                </td>
            </tr>
        <?php
        }
        echo "</table>";
        ?>
</body>

</html>