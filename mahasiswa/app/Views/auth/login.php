<?php
$rememberedUsername = $rememberedUsername ?? '';
$lastLoginAt = $lastLoginAt ?? '';
?>

<h2>Silahkan Login</h2>
<p class="muted">Masukkan username dan password.</p>

<?php if (!empty($lastLoginAt)): ?>
    <p class="muted">Cookie terakhir tersimpan untuk user <strong><?php echo htmlspecialchars($rememberedUsername); ?></strong> pada <?php echo htmlspecialchars($lastLoginAt); ?>.</p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" action="index.php?route=login">
    <table>
        <tr>
            <th>Username</th>
            <td><input type="text" name="username" placeholder="ID" value="<?php echo htmlspecialchars($rememberedUsername); ?>" required></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><input type="password" name="password" placeholder="Password" required></td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit">Sign in</button></td>
        </tr>
    </table>
</form>
<div class="link-row">
    <a href="index.php?route=register">Daftar</a>
</div>
