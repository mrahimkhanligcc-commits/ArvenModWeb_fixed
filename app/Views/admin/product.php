<!DOCTYPE html>
<html>
<head>
    <title><?= $product['name'] ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header nav {
            background: #333;
            padding: 10px;
        }

        header nav a {
            color: #fff;
            margin-right: 15px;
            text-decoration: none;
        }

        #product-details {
            padding: 30px;
            max-width: 900px;
            margin: auto;
            display: flex;
            gap: 30px;
        }

        #product-details img {
            width: 350px;
            height: 350px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        #product-info {
            flex: 1;
        }

        #product-info h1 {
            margin-top: 0;
        }

        #product-info p {
            margin: 10px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }

        .btn:hover {
            background: #0056b3;
        }

        .btn-green {
            background: #28a745;
        }

        .btn-green:hover {
            background: #1e7e34;
        }
    </style>
</head>

<body>

<header>
    <nav>
        <a href="/">Home</a>
        <a href="/products">Products</a>
        <a href="/cart">Cart</a>
    </nav>
</header>

<section id="product-details">
    <img src="/assets/images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">

    <div id="product-info">
        <h1><?= $product['name'] ?></h1>

        <p><strong>Price:</strong> £<?= $product['price'] ?></p>

        <p><?= $product['description'] ?></p>

        <a href="/cart/add?id=<?= $product['product_id'] ?>" class="btn btn-green">
            Add to Cart
        </a>
    </div>
</section>

</body>
</html>
