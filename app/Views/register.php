<section class="page-section narrow-section">
    <div class="auth-card">
        <p class="eyebrow">JOIN ARVEN</p>
        <h1>Create an Account</h1>

        <?php if (!empty($error)): ?>
            <div class="form-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/register">
            <label for="name">Full Name</label>
            <input id="name" type="text" name="name" required autocomplete="name">

            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" required autocomplete="email">

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required minlength="6" autocomplete="new-password">

            <label for="confirm_password">Confirm Password</label>
            <input id="confirm_password" type="password" name="confirm_password" required minlength="6" autocomplete="new-password">

            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>

        <p class="auth-switch">
            Already have an account?
            <a href="/login">Login here</a>
        </p>
    </div>
</section>
