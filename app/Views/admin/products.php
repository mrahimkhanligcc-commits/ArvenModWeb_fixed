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
            <h1>Products</h1>
        </div>
        <a href="/admin/add-product" class="btn btn-primary">Add Product</a>
    </div>

    <div class="cart-table-wrap">
        <table class="shop-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Size</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= (int)$product['product_id'] ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td>£<?= number_format((float)$product['price'], 2) ?></td>
                        <td><?= htmlspecialchars($product['size']) ?></td>
                        <td><?= (int)$product['stock'] ?></td>
                        <td>
                            <a class="text-link danger"
                               href="/admin/delete-product?id=<?= (int)$product['product_id'] ?>"
                               onclick="return confirm('Delete this product?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
