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
            <h1>Orders</h1>
        </div>
    </div>

    <div class="cart-table-wrap">
        <table class="shop-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= (int)$order['order_id'] ?></td>
                        <td><?= htmlspecialchars($order['customer_name']) ?></td>
                        <td>£<?= number_format((float)$order['total_amount'], 2) ?></td>
                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                        <td>
                            <a href="/admin/order-details?id=<?= (int)$order['order_id'] ?>"
                               class="text-link">
                                View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
