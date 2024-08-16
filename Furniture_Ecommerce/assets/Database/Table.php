<?php 
require_once "./Connection.php";



"CREATE TABLE IF NOT EXISTS products(
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    FOREIGN KEY (category_id) REFERENCES category(category_id),
    product_name VARCHAR(225) NOT NULL,
    product_brand VARCHAR(225) NOT NULL,
    product_description TEXT NOT NULL,
    product_price DOUBLE,
    product_stock INT,
    product_image VARCHAR(225)
    );
    ";


"CREATE TABLE IF NOT EXISTS category(
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(225) NOT NULL UNIQUE
    );
    ";