<?php
$username = $username ?? '';
$avatarUrl = $avatarUrl ?? 'assets/img/default-avatar.jpg';
?>

<div class="split-layout">
    <section class="panel">
        <h2>Overview</h2>
        <p class="muted">Ringkasan akun yang sedang aktif.</p>

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
                <td>Profile, Data Mahasiswa, dan Upload Avatar</td>
            </tr>
            <tr>
                <td>Cookie Username</td>
                <td><?php echo htmlspecialchars($rememberedUsername !== '' ? $rememberedUsername : '-'); ?></td>
            </tr>
            <tr>
                <td>Cookie Waktu Login</td>
                <td><?php echo htmlspecialchars($lastLoginAt !== '' ? $lastLoginAt : '-'); ?></td>
            </tr>
        </table>
    </section>

    <aside class="panel avatar-side-card">
        <h3>Foto Profil</h3>
        <img class="avatar-image avatar-image--profile" src="<?php echo htmlspecialchars($avatarUrl); ?>" alt="Avatar user">
        <p class="muted">Foto yang tampil di akun Anda.</p>
    </aside>
</div>
