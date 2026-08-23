<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION['auth']['logged_in']);
$isAdmin = !empty($_SESSION['auth']['role']) && $_SESSION['auth']['role'] === 'admin';
?>

<header class="site-header">
    <a href="/" class="site-logo" aria-label="Arven Online Shop home">
        <img src="/assets/images/arven-logo.png" alt="Arven Online Shop">
    </a>

    <nav class="site-nav" aria-label="Main navigation">
        <a href="/">Home</a>
        <a href="/products">Products</a>
        <a href="/cart">Cart</a>

        <?php if ($isAdmin): ?>
            <a href="/admin">Admin</a>
        <?php endif; ?>
    </nav>

    <div class="auth-buttons">
        <?php if (!$isLoggedIn): ?>
            <a href="/login" class="nav-button nav-button-primary">Login</a>
            <a href="/register" class="nav-button nav-button-outline">Register</a>
        <?php else: ?>
            <?php if ($isAdmin): ?>
                <a href="/admin" class="nav-button nav-button-outline">Dashboard</a>
            <?php endif; ?>
            <a href="/logout" class="nav-button nav-button-primary">Logout</a>
        <?php endif; ?>
    </div>

    <button class="mobile-menu-toggle"
            type="button"
            aria-label="Open navigation menu"
            aria-expanded="false"
            aria-controls="mobile-menu">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <div class="mobile-menu" id="mobile-menu">
        <a href="/">Home</a>
        <a href="/products">Products</a>
        <a href="/cart">Cart</a>

        <?php if ($isAdmin): ?>
            <a href="/admin">Admin</a>
        <?php endif; ?>

        <?php if (!$isLoggedIn): ?>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        <?php else: ?>
            <a href="/logout">Logout</a>
        <?php endif; ?>
    </div>
</header>
