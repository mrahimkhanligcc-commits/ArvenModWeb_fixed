<section class="page-section narrow-section">
    <div class="success-card">
        <p class="eyebrow">THANK YOU</p>
        <h1>Your Order Has Been Placed</h1>
        <p>Your Arven order number is <strong>#<?= (int)$order['order_id'] ?></strong>.</p>

        <div class="order-customer">
            <p><strong>Name:</strong> <?= htmlspecialchars($order['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
            <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($order['address'])) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
        </div>

        <h2>Order Items</h2>

        <div class="cart-table-wrap">
            <table class="shop-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= (int)$item['quantity'] ?></td>
                            <td>£<?= number_format((float)$item['price_at_purchase'], 2) ?></td>
                            <td>£<?= number_format((float)$item['price_at_purchase'] * (int)$item['quantity'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <p class="order-total">
            Order Total: £<?= number_format((float)$order['total_amount'], 2) ?>
        </p>

        <a href="/products" class="btn btn-primary">Continue Shopping</a>
    </div>
</section>
