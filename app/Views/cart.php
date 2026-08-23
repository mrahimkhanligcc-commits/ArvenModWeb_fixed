<section class="page-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">ARVEN SHOPPING BAG</p>
            <h1>Your Cart</h1>
        </div>
        <a href="/products">Continue Shopping →</a>
    </div>

    <?php if (empty($cartItems)): ?>
        <div class="empty-state">
            <h2>Your cart is empty</h2>
            <p>Add a product to your cart and it will appear here.</p>
            <a href="/products" class="btn btn-primary">Browse Products</a>
        </div>
    <?php else: ?>
        <div class="cart-layout">
            <div class="cart-table-wrap">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    <div class="cart-product">
                                        <?php
                                            $image = !empty($item['image']) ? $item['image'] : 'product-placeholder.svg';
                                            $imagePath = '/assets/images/' . rawurlencode($image);
                                        ?>
                                        <img src="<?= htmlspecialchars($imagePath) ?>"
                                             alt="<?= htmlspecialchars($item['name']) ?>">
                                        <span><?= htmlspecialchars($item['name']) ?></span>
                                    </div>
                                </td>
                                <td><?= (int)$item['quantity'] ?></td>
                                <td>£<?= number_format((float)$item['price'], 2) ?></td>
                                <td>£<?= number_format((float)$item['total'], 2) ?></td>
                                <td>
                                    <a class="text-link danger"
                                       href="/cart/remove?id=<?= (int)$item['product_id'] ?>">
                                        Remove
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <aside class="cart-summary">
                <h2>Order Summary</h2>
                <div class="summary-row">
                    <span>Total</span>
                    <strong>£<?= number_format((float)$cartTotal, 2) ?></strong>
                </div>

                <a href="/checkout" class="btn btn-primary btn-block">
                    Proceed to Checkout
                </a>

                <a href="/cart/clear" class="text-link">
                    Clear Cart
                </a>
            </aside>
        </div>
    <?php endif; ?>
</section>
