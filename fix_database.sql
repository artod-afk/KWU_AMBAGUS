-- ============================================
-- Fix Database - Jalankan di phpMyAdmin
-- Database: stok_sembako
-- Aman dijalankan meski sebagian sudah ada
-- ============================================

USE stok_sembako;

-- STEP 1: Tambah category_id jika belum ada
SET @col_exists = (
    SELECT COUNT(*) FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = 'stok_sembako'
    AND TABLE_NAME = 'products'
    AND COLUMN_NAME = 'category_id'
);
SET @sql = IF(@col_exists = 0,
    'ALTER TABLE `products` ADD COLUMN `category_id` BIGINT UNSIGNED NULL AFTER `id`',
    'SELECT "category_id already exists"'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- STEP 2: Tambah foreign key category_id jika belum ada
SET @fk_exists = (
    SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS
    WHERE TABLE_SCHEMA = 'stok_sembako'
    AND TABLE_NAME = 'products'
    AND CONSTRAINT_NAME = 'products_category_id_foreign'
);
SET @sql2 = IF(@fk_exists = 0,
    'ALTER TABLE `products` ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL',
    'SELECT "FK already exists"'
);
PREPARE stmt2 FROM @sql2; EXECUTE stmt2; DEALLOCATE PREPARE stmt2;

-- STEP 3: Update data lama (unit angka → selling_price & purchase_price)
UPDATE `products`
SET
    `selling_price` = CAST(`unit` AS DECIMAL(15,2)),
    `purchase_price` = CAST(`unit` AS DECIMAL(15,2)),
    `unit` = 'Pcs'
WHERE `unit` REGEXP '^[0-9]+$'
  AND `selling_price` = 0;

-- STEP 4: Buat tabel transactions
CREATE TABLE IF NOT EXISTS `transactions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(255) NOT NULL UNIQUE,
    `total_amount` DECIMAL(15,2) NOT NULL DEFAULT 0,
    `paid_amount` DECIMAL(15,2) NOT NULL DEFAULT 0,
    `change_amount` DECIMAL(15,2) NOT NULL DEFAULT 0,
    `total_items` INT NOT NULL DEFAULT 0,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL
);

-- STEP 5: Buat tabel transaction_items
CREATE TABLE IF NOT EXISTS `transaction_items` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `transaction_id` BIGINT UNSIGNED NOT NULL,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `product_name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(15,2) NOT NULL,
    `quantity` INT NOT NULL,
    `subtotal` DECIMAL(15,2) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    CONSTRAINT `fk_trx_transaction`
        FOREIGN KEY (`transaction_id`) REFERENCES `transactions`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_trx_product`
        FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
);

-- STEP 6: Verifikasi hasil
SELECT 'products columns:' AS info;
SELECT COLUMN_NAME, COLUMN_TYPE FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = 'stok_sembako' AND TABLE_NAME = 'products'
ORDER BY ORDINAL_POSITION;

SELECT 'tables created:' AS info;
SHOW TABLES;
