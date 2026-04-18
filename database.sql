CREATE DATABASE IF NOT EXISTS food_delivery_app;
USE food_delivery_app;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    payment_method VARCHAR(50) DEFAULT 'Cash on Delivery',
    payment_status VARCHAR(50) DEFAULT 'Unpaid',
    delivery_address VARCHAR(255) DEFAULT NULL,
    customer_note TEXT DEFAULT NULL,
    driver_name VARCHAR(100) DEFAULT 'Driver A',
    driver_phone VARCHAR(20) DEFAULT '0901234567',
    delivery_status VARCHAR(50) DEFAULT 'Preparing',
    tracking_lat DECIMAL(10,6) DEFAULT 10.776889,
    tracking_lng DECIMAL(10,6) DEFAULT 106.700806,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders(id),
    CONSTRAINT fk_order_items_menu FOREIGN KEY (menu_item_id) REFERENCES menu_items(id)
);

INSERT INTO users (full_name, email, phone, password, role)
SELECT 'Administrator', 'admin@fooddash.com', '0900000001', 'admin123', 'admin'
WHERE NOT EXISTS (
    SELECT 1 FROM users WHERE email = 'admin@fooddash.com'
);

INSERT INTO menu_items (name, description, category, price, image_url) VALUES
('Burger bò đặc biệt', 'Burger mềm, bò nướng, phô mai cheddar và sốt nhà làm.', 'Burger', 79000, 'images/burger.svg'),
('Mì Ý sốt bò bằm', 'Mì Ý sốt cà chua, bò bằm và phô mai parmesan.', 'Pasta', 99000, 'images/pasta.svg'),
('Cơm gà sốt Hàn', 'Cơm mềm, gà chiên giòn, sốt cay ngọt kiểu Hàn.', 'Cơm', 85000, 'images/chicken-rice.svg'),
('Pizza hải sản mini', 'Đế mỏng, tôm, mực, phô mai mozzarella.', 'Pizza', 129000, 'images/pizza.svg'),
('Trà sữa trân châu', 'Hồng trà sữa đậm vị kèm trân châu đen.', 'Đồ uống', 45000, 'images/milk-tea.svg'),
('Salad cá ngừ', 'Rau tươi, cá ngừ, trứng lòng đào và sốt mè rang.', 'Healthy', 69000, 'images/salad.svg');
