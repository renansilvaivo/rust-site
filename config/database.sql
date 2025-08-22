-- config/database.sql
CREATE DATABASE IF NOT EXISTS deepsite_rust CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE deepsite_rust;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  nickname VARCHAR(60) DEFAULT NULL,
  steam_id VARCHAR(32) DEFAULT NULL,
  balance DECIMAL(10,2) NOT NULL DEFAULT 0,
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) NOT NULL,
  slug VARCHAR(60) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NULL,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(120) UNIQUE NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS purchases (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  product_id INT NULL,
  custom_amount DECIMAL(10,2) NULL,
  payment_method ENUM('pix','paypal') NOT NULL,
  status ENUM('pending','paid','cancelled','failed') NOT NULL DEFAULT 'pending',
  external_ref VARCHAR(120) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE IF NOT EXISTS logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  action VARCHAR(120) NOT NULL,
  meta TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Seed categories and example products
INSERT INTO categories (name, slug) VALUES
  ('VIP', 'vip'),
  ('Itens', 'itens')
ON DUPLICATE KEY UPDATE name=VALUES(name);

INSERT INTO products (category_id, name, slug, description, price, is_active)
VALUES
  ((SELECT id FROM categories WHERE slug='vip'), 'VIP Bronze', 'vip-bronze', 'Acesso a /kit bronze, fila prioritária, 1x TP extra/dia.', 19.90, 1),
  ((SELECT id FROM categories WHERE slug='vip'), 'VIP Prata', 'vip-prata', 'Benefícios do Bronze + /home extra e /kit prata.', 29.90, 1),
  ((SELECT id FROM categories WHERE slug='vip'), 'VIP Ouro', 'vip-ouro', 'Benefícios do Prata + crafting rápido, /kit ouro.', 49.90, 1),
  ((SELECT id FROM categories WHERE slug='itens'), 'Kit Inicial', 'kit-inicial', 'Armas básicas, roupas e recursos iniciais.', 9.90, 1)
ON DUPLICATE KEY UPDATE name=VALUES(name), description=VALUES(description), price=VALUES(price), is_active=VALUES(is_active);
