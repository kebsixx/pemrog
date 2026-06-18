<?php
$flash = $flash ?? null;
$avatarUrl = $avatarUrl ?? 'assets/img/default-avatar.jpg';
?>

<h2>Profile Mahasiswa</h2>
<p class="muted">Halaman ini hanya menampilkan data akun yang sedang login.</p>

<?php if (!empty($flash)): ?>
    <div class="<?php echo ($flash['type'] ?? '') === 'success' ? 'success' : 'error'; ?>">
        <?php echo htmlspecialchars($flash['message'] ?? ''); ?>
    </div>
<?php endif; ?>

<?php if (empty($profile)): ?>
    <p class="error">Data profile tidak ditemukan.</p>
<?php else: ?>
    <div class="split-layout">
        <section class="panel">
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
        </section>

        <aside class="panel avatar-side-card">
            <h3>Foto Profil</h3>
            <img class="avatar-image avatar-image--profile" src="<?php echo htmlspecialchars($avatarUrl); ?>" alt="Avatar profile">
            <p class="muted">
                <?php echo !empty($profile['avatar_nama_file']) ? 'Foto profil sudah tersimpan.' : 'Belum ada foto profil yang diunggah.'; ?>
            </p>
        </aside>
    </div>
<?php endif; ?>
