<?php
$flash = $flash ?? null;
$avatar = $avatar ?? null;
$avatarUrl = $avatarUrl ?? 'assets/img/default-avatar.jpg';
?>

<h2 class="page-title">Upload Avatar</h2>
<p class="muted">Unggah foto profil dari komputer Anda.</p>

<?php if (!empty($flash)): ?>
    <div class="<?php echo ($flash['type'] ?? '') === 'success' ? 'success' : 'error'; ?>">
        <?php echo htmlspecialchars($flash['message'] ?? ''); ?>
    </div>
<?php endif; ?>

<div class="avatar-grid">
    <section class="panel avatar-form-card">
        <h3>Unggah Foto Profil</h3>
        <form method="post" action="index.php?route=task-upload" enctype="multipart/form-data" class="task-form">
            <label for="berkas">Pilih File Gambar</label>
            <input type="file" id="berkas" name="berkas" accept=".jpg,.jpeg,.png,.gif" required>

            <p class="muted">Format: JPG, JPEG, PNG, GIF. Maksimal 2 MB.</p>
            <button type="submit">Simpan Foto</button>
        </form>
    </section>

    <section class="panel avatar-preview-card avatar-preview-card--upload">
        <h3>Foto Saat Ini</h3>
        <img class="avatar-image avatar-image--upload" src="<?php echo htmlspecialchars($avatarUrl); ?>" alt="Avatar user">
        <table>
            <tr>
                <th>Status</th>
                <td><?php echo !empty($avatar['avatar_nama_file']) ? 'Tersimpan' : 'Default'; ?></td>
            </tr>
            <tr>
                <th>Nama File</th>
                <td><?php echo htmlspecialchars($avatar['avatar_nama_asli'] ?? 'default-avatar.jpg'); ?></td>
            </tr>
            <tr>
                <th>Ukuran</th>
                <td><?php echo !empty($avatar['avatar_ukuran_file']) ? htmlspecialchars(number_format(((int) $avatar['avatar_ukuran_file']) / 1024, 2) . ' KB') : '-'; ?></td>
            </tr>
        </table>

        <?php if (!empty($avatar['avatar_nama_file'])): ?>
            <p><a href="index.php?route=task-download">Unduh Foto</a></p>
        <?php endif; ?>
    </section>
</div>
