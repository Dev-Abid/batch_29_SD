-- ============================================================
-- Simple PHP CRUD - Database Schema & Seed Data
-- Run this file in phpMyAdmin or via MySQL CLI:
-- mysql -u root -P 3306 < database/schema.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS simple_php_crud
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE simple_php_crud;

DROP TABLE IF EXISTS employees;

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    role VARCHAR(50) NOT NULL,
    salary DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed sample employees for demonstration
INSERT INTO employees (name, email, phone, role, salary) VALUES
('Alice Johnson', 'alice@example.com', '01711000001', 'Software Developer', 65000.00),
('Bob Smith', 'bob@example.com', '01711000002', 'SQA Engineer', 55000.00),
('Charlie Davis', 'charlie@example.com', '01711000003', 'Project Manager', 80000.00);
