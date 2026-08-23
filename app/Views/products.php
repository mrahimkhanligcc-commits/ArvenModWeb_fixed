<section class="page-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">ARVEN COLLECTION</p>
            <h1>Products</h1>
        </div>
        <a href="/cart">View Cart →</a>
    </div>

    <?php if (empty($products)): ?>
        <div class="empty-state">
            <h3>No products available</h3>
            <p>Please check back soon.</p>
        </div>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <?php
                    $image = !empty($product['image']) ? $product['image'] : 'product-placeholder.svg';
                    $imagePath = '/assets/images/' . rawurlencode($image);
                    $inStock = (int)$product['stock'] > 0;
                ?>
                <article class="product-card">
                    <a href="/product?id=<?= (int)$product['product_id'] ?>" class="product-image-link">
                        <img src="<?= htmlspecialchars($imagePath) ?>"
                             alt="<?= htmlspecialchars($product['name']) ?>">
                    </a>

                    <div class="product-card-body">
                        <h2><?= htmlspecialchars($product['name']) ?></h2>

                        <p class="product-price">
                            £<?= number_format((float)$product['price'], 2) ?>
                        </p>

                        <p class="stock <?= $inStock ? 'in-stock' : 'out-of-stock' ?>">
                            <?= $inStock ? 'In stock' : 'Out of stock' ?>
                        </p>

                        <div class="product-actions">
                            <a href="/product?id=<?= (int)$product['product_id'] ?>"
                               class="btn btn-secondary">
                                View
                            </a>

                            <?php if ($inStock): ?>
                                <a href="/cart/add?id=<?= (int)$product['product_id'] ?>"
                                   class="btn btn-primary">
                                    Add to Cart
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
