<?php
declare(strict_types=1);

$isLoggedIn = !empty($_SESSION['user_id']);
$activeRoute = $activeRoute ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Mahasiswa'); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php if ($isLoggedIn): ?>
        <div class="app">
            <aside class="sidebar">
                <h1>Selamat Datang di Halaman Admin</h1>
                <ul class="menu">
                    <li><a class="<?php echo $activeRoute === 'overview' ? 'active' : ''; ?>" href="index.php?route=overview">Overview</a></li>
                    <li><a class="<?php echo $activeRoute === 'profile' ? 'active' : ''; ?>" href="index.php?route=profile">Profile User</a></li>
                    <li><a class="<?php echo $activeRoute === 'mahasiswa' ? 'active' : ''; ?>" href="index.php?route=mahasiswa">Data Mahasiswa</a></li>
                    <li><a class="<?php echo $activeRoute === 'tasks' ? 'active' : ''; ?>" href="index.php?route=tasks">Upload Avatar</a></li>
                </ul>
            </aside>
            <div class="main">
                <div class="topbar">
                    <div class="search"><input type="text" placeholder="Search..."></div>
                    <div class="links">
                        <a href="index.php?route=overview">Dashboard</a>
                        <a href="index.php?route=profile">Profile</a>
                        <a href="index.php?route=logout">Logout</a>
                    </div>
                </div>
                <main class="content">
                    <div class="panel">
    <?php else: ?>
        <div class="auth-wrap">
            <div class="auth-card">
    <?php endif; ?>
