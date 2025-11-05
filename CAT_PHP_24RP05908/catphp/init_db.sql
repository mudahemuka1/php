CREATE DATABASE IF NOT EXISTS library CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE library;
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  student_id VARCHAR(50) NOT NULL UNIQUE,
  role ENUM('student','admin') NOT NULL DEFAULT 'student',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS books (
  book_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  authors VARCHAR(200) NOT NULL,
  category VARCHAR(100) NOT NULL,
  available_status TINYINT(1) NOT NULL DEFAULT 1
);
CREATE TABLE IF NOT EXISTS borrowed_books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id VARCHAR(50) NOT NULL,
  book_id INT NOT NULL,
  borrow_date DATETIME NOT NULL,
  return_date DATETIME NULL,
  FOREIGN KEY (book_id) REFERENCES books(book_id)
);
INSERT INTO users (username, email, password_hash, student_id, role) VALUES
('Admin', 'admin@library.local', '$2y$10$u7Z0l4mW2mW8d1Q6b6VwX.cqk9qYc.1qO0kQp8y7m4Gm0z3Lxg1f2', 'A0001', 'admin');
