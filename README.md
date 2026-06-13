# SKINLUXE

A beauty and skincare products e-commerce website built with PHP and MySQL. Supports user registration, login, admin panel, and full product management (CRUD) with image upload.

## Features

- User authentication (register / login / logout)
- Role-based access control (admin / user)
- Admin dashboard to manage users and products
- Product listing with detail page (description, ingredients, results)
- Image upload for products
- Product search by name
- Arabic (RTL) interface
- Responsive dark theme

## Requirements

- PHP 7.4+
- MySQL / MariaDB
- PDO MySQL extension

## Installation

1. Clone the repository:
```bash
git clone <repo-url>
```

2. Import the database schema into a database named `nadia_project`:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    ingredients TEXT,
    results TEXT,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. Configure database connection in `config/db.php`:
```php
$host = "localhost";
$dbname = "nadia_project";
$username = "root";
$password = "";
```

4. Place the project in Laragon's `www` folder (or start a PHP server):
```bash
php -S localhost:8000
```

5. Open `http://localhost/nadia_project` in your browser.

## Default Admin Access

Run this SQL to create an admin account:
```sql
INSERT INTO users (username, email, password, role)
VALUES ('admin', 'admin@skinluxe.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
```
Login with `admin@skinluxe.com` / `admin123`.

## Project Structure

```
├── index.php                  # Entry point (home page with search)
├── config/
│   └── db.php                 # Database connection
├── includes/
│   ├── header.php             # Shared header with nav
│   └── footer.php             # Shared footer
├── public/
│   ├── css/style.css          # Stylesheet
│   ├── js/search.js           # Search enhancement JS
│   └── images/                # Uploaded product images
├── admin/
│   ├── index.php              # Admin dashboard (users + products)
│   ├── add_product.php        # Add new product with image upload
│   ├── edit.php               # Edit product
│   └── delete.php             # Delete product
├── auth/
│   ├── login.php              # User login
│   ├── register.php           # User registration
│   └── logout.php             # Logout
├── pages/
│   ├── products.php           # User product catalog with search
│   ├── product_detail.php     # Product detail page
│   └── order_action.php       # Order confirmation
├── meta                       # SQL schema reference
├── README.md
├── LICENSE
└── .gitignore
```

## License

[MIT](LICENSE)
