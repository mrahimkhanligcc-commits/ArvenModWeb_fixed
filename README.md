# Arven Online Shop

A small PHP MVC online shop for local development with XAMPP/Apache or PHP's built-in server.

## Requirements

- PHP 8.1+
- MariaDB/MySQL
- PDO MySQL extension

## Database

1. Open phpMyAdmin.
2. Import `config/arven.sql`.
3. The default local database is `arven`.
4. The project expects the XAMPP default MySQL user:
   - user: `root`
   - password: empty

If your database credentials are different, edit `app/core/Database.php`.

## Run with PHP's built-in server

From the project folder:

```bash
php -S localhost:8000 -t public
```

Then open:

```text
http://localhost:8000/
```

## Local admin account

The SQL file creates a development administrator:

```text
Email: admin@arven.local
Password: Admin123!
```

Change or remove this account before using the project anywhere outside local development.

## Main routes

- `/`
- `/products`
- `/product?id=1`
- `/cart`
- `/checkout`
- `/login`
- `/register`
- `/logout`
- `/admin`
- `/admin/products`
- `/admin/orders`
- `/admin/customers`

The project uses a single front controller at `public/index.php`.
