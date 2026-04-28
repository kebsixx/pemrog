<!DOCTYPE html>
<html>

<head>
    <title>Detail Kontak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 24px;
            color: #1f2937;
        }

        .card {
            max-width: 620px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .back-link,
        .edit-link {
            display: inline-block;
            text-decoration: none;
            background: #2563eb;
            color: #fff;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
        }

        .back-link {
            background: #4b5563;
            margin-bottom: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #f9fafb;
            border-radius: 8px;
            overflow: hidden;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        tr:last-child td {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>Detail Kontak Bisnis</h2>
        <a class="back-link" href="index.php">KEMBALI KE DAFTAR</a>
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
                <table>
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
                <a class="edit-link" href="editKontak.php?id=<?php echo $row[0]; ?>">Edit Data Ini</a>
        <?php
            } else {
                echo "Data tidak ditemukan.";
            }
        }
        ?>
    </div>
</body>

</html>