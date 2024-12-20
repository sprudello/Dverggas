-- Database ---
CREATE DATABASE IF NOT EXISTS Dverggas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE Dverggas;

-- Enable proper timestamp and charset handling
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET time_zone = '+01:00';

SET SQL_MODE = 'ALLOW_INVALID_DATES,NO_ZERO_DATE,NO_ZERO_IN_DATE';

-- Tables ---
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    display_name VARCHAR(32) NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    email_verified BOOLEAN DEFAULT 0,
    phone_number VARCHAR(16) NULL UNIQUE,
    phone_verified BOOLEAN DEFAULT 0,
    street VARCHAR(255) NOT NULL,
    street2 VARCHAR(255) NULL,
    house_number VARCHAR(32) NOT NULL,
    plz VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    avatar_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    parent_id INT NULL,
    FOREIGN KEY (parent_id) REFERENCES categories(id)
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    title VARCHAR(48) NOT NULL,
    prod_desc VARCHAR(255) NULL,
    price DECIMAL(12, 2) NULL,
    brand VARCHAR(16) NOT NULL,
    release_date TIMESTAMP NOT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id),
    CONSTRAINT unique_wishlist_item UNIQUE (user_id, product_id)
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(12, 2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price_at_time DECIMAL(12, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE IF NOT EXISTS payment_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    payment_type ENUM('credit_card', 'debit_card', 'bank_transfer', 'paypal', 'crypto', 'apple_pay', 'google_pay') NOT NULL,
    card_number VARBINARY(255) NULL,
    card_holder_name VARBINARY(255) NULL,
    expiry_date DATE NULL,
    cvv VARBINARY(255) NULL,
    bank_name VARBINARY(255) NULL,
    account_number VARBINARY(255) NULL,
    routing_number VARBINARY(255) NULL,
    paypal_email VARBINARY(255) NULL,
    is_default BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT unique_default_per_user UNIQUE (user_id, is_default)
);