<?php
$username = $username ?? '';
?>

<h2>Overview</h2>
<table>
    <tr>
        <th>Informasi</th>
        <th>Nilai</th>
    </tr>
    <tr>
        <td>Status Login</td>
        <td>Aktif</td>
    </tr>
    <tr>
        <td>Username</td>
        <td><?php echo htmlspecialchars($username); ?></td>
    </tr>
    <tr>
        <td>Menu</td>
        <td>Profile dan Data Mahasiswa</td>
    </tr>
</table>
