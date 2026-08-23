<section class="hero">
    <div class="hero-content">
        <p class="eyebrow">WELCOME TO ARVEN</p>
        <h1>Discover your next favourite piece.</h1>
        <p>Explore our collection of carefully selected products, designed to bring style and quality to your everyday life.</p>
        <a href="/products" class="btn btn-primary">Shop Products</a>
    </div>
</section>

<section class="page-section">
    <div class="section-heading">
        <h2>Featured Products</h2>
        <a href="/products">View all products →</a>
    </div>

    <?php if (empty($featured)): ?>
        <div class="empty-state">
            <h3>No products yet</h3>
            <p>Add products from the admin panel to display them here.</p>
        </div>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($featured as $product): ?>
                <?php
                    $image = !empty($product['image']) ? $product['image'] : 'product-placeholder.svg';
                    $imagePath = '/assets/images/' . rawurlencode($image);
                ?>
                <article class="product-card">
                    <a href="/product?id=<?= (int)$product['product_id'] ?>" class="product-image-link">
                        <img src="<?= htmlspecialchars($imagePath) ?>"
                             alt="<?= htmlspecialchars($product['name']) ?>">
                    </a>

                    <div class="product-card-body">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="product-price">£<?= number_format((float)$product['price'], 2) ?></p>

                        <a href="/product?id=<?= (int)$product['product_id'] ?>"
                           class="btn btn-secondary">
                            View Product
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
