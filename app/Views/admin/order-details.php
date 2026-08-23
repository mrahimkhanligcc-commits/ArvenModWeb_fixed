<section class="page-section">
    
<div class="admin-nav">
    <a href="/admin">Dashboard</a>
    <a href="/admin/orders">Orders</a>
    <a href="/admin/products">Products</a>
    <a href="/admin/customers">Customers</a>
</div>

    <div class="section-heading">
        <div>
            <p class="eyebrow">ARVEN ADMIN</p>
            <h1>Order #<?= (int)$order['order_id'] ?></h1>
        </div>
    </div>

    <div class="admin-info-card">
        <h2>Customer Information</h2>
        <p><strong>Name:</strong> <?= htmlspecialchars($order['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
        <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($order['address'])) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
    </div>

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
</section>
