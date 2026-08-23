<section class="page-section narrow-section">
    
<div class="admin-nav">
    <a href="/admin">Dashboard</a>
    <a href="/admin/orders">Orders</a>
    <a href="/admin/products">Products</a>
    <a href="/admin/customers">Customers</a>
</div>

    <div class="section-heading">
        <div>
            <p class="eyebrow">ARVEN ADMIN</p>
            <h1>Add Product</h1>
        </div>
    </div>

    <form method="POST" action="/admin/save-product" class="form-card">
        <label for="name">Product Name</label>
        <input id="name" type="text" name="name" required>

        <label for="price">Price (£)</label>
        <input id="price" type="number" name="price" step="0.01" min="0" required>

        <label for="size">Size</label>
        <select id="size" name="size" required>
            <option value="S">S</option>
            <option value="M" selected>M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="XXL">XXL</option>
        </select>

        <label for="image">Image Filename</label>
        <input id="image" type="text" name="image" placeholder="product-placeholder.svg">

        <label for="stock">Stock</label>
        <input id="stock" type="number" name="stock" min="0" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="5" required></textarea>

        <button type="submit" class="btn btn-primary btn-block">Save Product</button>
    </form>
</section>
