-- Database ---
CREATE DATABASE IF NOT EXISTS Dverggas;
USE Dverggas;

-- Enable proper timestamp handling
SET SQL_MODE = 'ALLOW_INVALID_DATES';

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
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
    kontentyp ENUM('Unternehmen', 'Privatperson') NOT NULL
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

USE Dverggas;

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
