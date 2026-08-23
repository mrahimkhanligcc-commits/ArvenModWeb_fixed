<section class="page-section narrow-section">
    <div class="auth-card">
        <p class="eyebrow">WELCOME BACK</p>
        <h1>Login</h1>

        <?php if (!empty($error)): ?>
            <div class="form-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/login">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" required autocomplete="email">

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">

            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <p class="auth-switch">
            Don't have an account?
            <a href="/register">Register here</a>
        </p>
    </div>
</section>
