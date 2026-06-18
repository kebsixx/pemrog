<h2>Profile Mahasiswa</h2>
<p class="muted">Halaman ini hanya menampilkan data akun yang sedang login.</p>

<?php if (empty($profile)): ?>
    <p class="error">Data profile tidak ditemukan.</p>
<?php else: ?>
    <table>
        <tr><th>ID</th><td><?php echo htmlspecialchars((string) $profile['id']); ?></td></tr>
        <tr><th>NRP</th><td><?php echo htmlspecialchars($profile['nrp'] ?? ''); ?></td></tr>
        <tr><th>Nama</th><td><?php echo htmlspecialchars($profile['nama'] ?? ''); ?></td></tr>
        <tr><th>Alamat</th><td><?php echo htmlspecialchars($profile['alamat'] ?? ''); ?></td></tr>
        <tr><th>TTL</th><td><?php echo htmlspecialchars($profile['ttl'] ?? ''); ?></td></tr>
        <tr><th>Email</th><td><?php echo htmlspecialchars($profile['email'] ?? ''); ?></td></tr>
        <tr><th>No HP</th><td><?php echo htmlspecialchars($profile['nohp'] ?? ''); ?></td></tr>
        <tr><th>Username</th><td><?php echo htmlspecialchars($profile['username'] ?? ''); ?></td></tr>
    </table>
<?php endif; ?>
