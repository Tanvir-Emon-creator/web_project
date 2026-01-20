<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Property Buy & Rent Management</title>
    <link rel="stylesheet" href="/project/resources/css/style.css">
    <script src="/project/resources/js/theme.js" defer></script>
</head>
<body>

<header class="navbar">
    <div class="logo">
        <a href="/project/index.php">Property Buy & Rent</a>
    </div>
    <div class="nav-links">
        <?php if (isset($_SESSION['role'])): ?>
            <a href="/project/views/<?= $_SESSION['role'] ?>/dashboard.php">Dashboard</a>
            <a href="/project/controllers/AuthController.php?action=logout">Logout</a>
        <?php else: ?>
            <a href="/project/views/auth/login.php">Login</a>
        <?php endif; ?>
        <button id="themeToggle">🌙 / ☀️</button>
    </div>
</header>

<main class="container">
