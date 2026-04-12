<!DOCTYPE html>
<html>

<head>
    <title>Kontak Bisnis</title>
</head>

<body>
    <h2>Kontak Bisnis - MS Access</h2>
    <br />
    <a href="index.php">KEMBALI</a>
    <br />
    <br />
    <h3>Tambah Data Kontak Bisnis</h3>
    <form method="post" action="tambahKontak_aksi.php">
        <table>
            <tr>
                <td>Nama Depan</td>
                <td><input type="text" name="NamaDepan"></td>
            </tr>
            <tr>
                <td>Nama Belakang</td>
                <td><input type="text" name="NamaBelakang"></td>
            </tr>
            <tr>
                <td>Alamat Email</td>
                <td><input type="text" name="AlamatEmail"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Tambah"></td>
            </tr>
        </table>
    </form>
</body>

</html>