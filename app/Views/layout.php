<?php
require BASE_PATH . '/app/Views/components/header.php';
require BASE_PATH . '/app/Views/components/nav.php';
?>

<main class="site-main">
    <?php require $view; ?>
</main>

<?php require BASE_PATH . '/app/Views/components/footer.php'; ?>
