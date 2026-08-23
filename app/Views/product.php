<section class="page-section">
    <div class="product-detail">
        <?php
            $image = !empty($product['image']) ? $product['image'] : 'product-placeholder.svg';
            $imagePath = '/assets/images/' . rawurlencode($image);
            $inStock = (int)$product['stock'] > 0;
        ?>

        <div class="product-detail-image">
            <img src="<?= htmlspecialchars($imagePath) ?>"
                 alt="<?= htmlspecialchars($product['name']) ?>">
        </div>

        <div class="product-detail-info">
            <p class="eyebrow">ARVEN PRODUCT</p>
            <h1><?= htmlspecialchars($product['name']) ?></h1>

            <p class="product-detail-price">
                £<?= number_format((float)$product['price'], 2) ?>
            </p>

            <?php if (!empty($product['size'])): ?>
                <p><strong>Size:</strong> <?= htmlspecialchars($product['size']) ?></p>
            <?php endif; ?>

            <p class="product-description">
                <?= nl2br(htmlspecialchars($product['description'])) ?>
            </p>

            <p class="stock <?= $inStock ? 'in-stock' : 'out-of-stock' ?>">
                <?= $inStock ? ((int)$product['stock'] . ' available') : 'Out of stock' ?>
            </p>

            <div class="product-actions">
                <?php if ($inStock): ?>
                    <a href="/cart/add?id=<?= (int)$product['product_id'] ?>"
                       class="btn btn-primary">
                        Add to Cart
                    </a>
                <?php endif; ?>

                <a href="/products" class="btn btn-secondary">Back to Products</a>
            </div>
        </div>
    </div>
</section>
