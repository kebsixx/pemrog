<h2>Register Mahasiswa</h2>
<p class="muted">Lengkapi data untuk membuat akun baru.</p>

<?php if (!empty($error)): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" action="index.php?route=register">
    <table>
        <tr>
            <th>Nama</th>
            <td><input type="text" name="nama" placeholder="Nama" value="<?php echo htmlspecialchars($old['nama'] ?? ''); ?>" maxlength="100" required></td>
        </tr>
        <tr>
            <th>NRP</th>
            <td><input type="text" name="nrp" placeholder="NRP" value="<?php echo htmlspecialchars($old['nrp'] ?? ''); ?>" maxlength="15" required></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td><input type="text" name="alamat" placeholder="Alamat" value="<?php echo htmlspecialchars($old['alamat'] ?? ''); ?>" maxlength="200" required></td>
        </tr>
        <tr>
            <th>Tempat dan Tanggal Lahir</th>
            <td><input type="text" name="ttl" placeholder="TTL" value="<?php echo htmlspecialchars($old['ttl'] ?? ''); ?>" maxlength="50" required></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" maxlength="50" required></td>
        </tr>
        <tr>
            <th>No HP</th>
            <td><input type="text" name="nohp" placeholder="No HP" value="<?php echo htmlspecialchars($old['nohp'] ?? ''); ?>" maxlength="50" required></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($old['username'] ?? ''); ?>" maxlength="50" required></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><input type="password" name="password" placeholder="Password" required></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Submit</button></td>
        </tr>
    </table>
</form>
<div class="link-row">
    <a href="index.php?route=login">Login di sini</a>
</div>
