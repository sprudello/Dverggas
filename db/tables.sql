-- Database ---
CREATE DATABASE Dverggas;

-- Tables ---
USE Dverggas;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

USE Dverggas;
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    parent_id INT NULL,
    FOREIGN KEY (parent_id) REFERENCES categories(id)
);

USE Dverggas;
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    FOREIGN KEY (category_id) REFERENCES categories(id)
    title VARCHAR(48) NOT NULL,
    prod_desc VARCHAR(255) NULL,
    price DECIMAL(12, 2) NULL,
    brand VARCHAR(16) NOT NULL,
    release_date TIMESTAMP NOT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
);
