-- Create the database if it doesn't already exist
CREATE DATABASE IF NOT EXISTS user_db;

-- Use the newly created database
USE user_db;

-- --------------------------------------------------------

--
-- Table structure for table `users`
-- (Referenced by `products`)
--
CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    mobile VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    role ENUM('Farmer', 'Buyer') NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--
CREATE TABLE IF NOT EXISTS products (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(255) NOT NULL,
    quantity FLOAT,
    price DECIMAL(10, 2) NOT NULL,
    shop_name VARCHAR(255),
    shopkeeper_name VARCHAR(255),
    
    -- Assuming user_id is a foreign key that links to the 'users' table
    -- ON DELETE SET NULL means if a user is deleted, their products remain but are no longer linked
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--
CREATE TABLE IF NOT EXISTS orders (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    shop_name VARCHAR(255),
    username VARCHAR(255),
    status VARCHAR(50),
    address TEXT,
    payment_mode VARCHAR(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--
CREATE TABLE IF NOT EXISTS contact_form (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    region VARCHAR(50),
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);