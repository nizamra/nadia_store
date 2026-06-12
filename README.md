# SKINLUXE

A beauty and skincare products e-commerce website built with PHP and MySQL. Supports user registration, login, admin panel, and full product management (CRUD).

## Features

- User authentication (register / login / logout)
- Role-based access control (admin / user)
- Admin dashboard to manage users and products
- Product listing with details (price, description, ingredients)
- Arabic (RTL) interface
- Responsive grid layout

## Requirements

- PHP 7.4+
- MySQL / MariaDB
- PDO MySQL extension

## Installation

1. Clone the repository:
```bash
git clone <repo-url>
```

2. Import the database schema. Create a database named `nadia_progect` and run:
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
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. Configure database connection in `db.php`:
```php
$host = "localhost";
$dbname = "nadia_progect";
$username = "root";
$password = "";
```

4. Start a PHP development server:
```bash
php -S localhost:8000
```

5. Open `http://localhost:8000` in your browser.

## Default Admin Access

Register a new account, then manually set the role to `admin` in the database:
```sql
UPDATE users SET role = 'admin' WHERE email = 'your@email.com';
```

## Project Structure

```
├── index.php          # Home page / product listing
├── login.php          # User login
├── register.php       # User registration
├── admin.php          # Admin dashboard
├── created_at.php     # Add new product
├── edit.php           # Edit product
├── delete.php         # Delete product
├── Product.php        # Product detail page (frontend)
├── user_products.php  # User products view
├── db.php             # Database connection
├── home.php           # Session check helper
├── header.php         # Page header
├── footer.php         # Page footer
├── order_action.php   # Order handling
├── test.php           # Test file
├── style.css          # Styles
└── images/            # Product images
```

## License

[MIT](LICENSE)
