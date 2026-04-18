USE food_delivery_app;

ALTER TABLE orders
ADD COLUMN payment_method VARCHAR(50) DEFAULT 'Cash on Delivery',
ADD COLUMN payment_status VARCHAR(50) DEFAULT 'Unpaid',
ADD COLUMN delivery_address VARCHAR(255) DEFAULT NULL,
ADD COLUMN customer_note TEXT DEFAULT NULL,
ADD COLUMN driver_name VARCHAR(100) DEFAULT 'Driver A',
ADD COLUMN driver_phone VARCHAR(20) DEFAULT '0901234567',
ADD COLUMN delivery_status VARCHAR(50) DEFAULT 'Preparing',
ADD COLUMN tracking_lat DECIMAL(10,6) DEFAULT 10.776889,
ADD COLUMN tracking_lng DECIMAL(10,6) DEFAULT 106.700806;

ALTER TABLE menu_items
ADD COLUMN image_url VARCHAR(255) DEFAULT NULL;

UPDATE menu_items SET image_url = 'images/burger.svg' WHERE id = 1;
UPDATE menu_items SET image_url = 'images/pasta.svg' WHERE id = 2;
UPDATE menu_items SET image_url = 'images/chicken-rice.svg' WHERE id = 3;
UPDATE menu_items SET image_url = 'images/pizza.svg' WHERE id = 4;
UPDATE menu_items SET image_url = 'images/milk-tea.svg' WHERE id = 5;
UPDATE menu_items SET image_url = 'images/salad.svg' WHERE id = 6;
