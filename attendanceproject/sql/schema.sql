-- schema.sql: Attendance System
-- Run: CREATE DATABASE attendance_db; USE attendance_db; SOURCE schema.sql;

-- roles
CREATE TABLE IF NOT EXISTS roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(32) UNIQUE NOT NULL
);

-- users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(150) NOT NULL,
  username VARCHAR(80) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role_id INT NOT NULL,
  matricule VARCHAR(50),
  group_id INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- groups
CREATE TABLE IF NOT EXISTS groups (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL
);

-- courses
CREATE TABLE IF NOT EXISTS courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(50) NOT NULL,
  title VARCHAR(150) NOT NULL
);

-- attendance_sessions
CREATE TABLE IF NOT EXISTS attendance_sessions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT NOT NULL,
  group_id INT NOT NULL,
  date DATE NOT NULL,
  opened_by INT NOT NULL,
  status ENUM('open','closed') DEFAULT 'open',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (course_id) REFERENCES courses(id),
  FOREIGN KEY (group_id) REFERENCES groups(id),
  FOREIGN KEY (opened_by) REFERENCES users(id)
);

-- attendance_records
CREATE TABLE IF NOT EXISTS attendance_records (
  id INT AUTO_INCREMENT PRIMARY KEY,
  session_id INT NOT NULL,
  user_id INT NOT NULL,
  status ENUM('present','absent','late') NOT NULL,
  note VARCHAR(255),
  recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (session_id) REFERENCES attendance_sessions(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- justifications
CREATE TABLE IF NOT EXISTS justifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  session_id INT NOT NULL,
  reason TEXT,
  file_path VARCHAR(255),
  status ENUM('pending','accepted','rejected') DEFAULT 'pending',
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (session_id) REFERENCES attendance_sessions(id)
);

-- seed roles
INSERT IGNORE INTO roles (id, name) VALUES
(1, 'student'),
(2, 'professor'),
(3, 'admin');

-- Example seed group and course
INSERT IGNORE INTO groups (id, name) VALUES (1, 'G1');
INSERT IGNORE INTO courses (id, code, title) VALUES (1, 'CS101', 'Introduction to Programming');

-- Example admin user (password: admin123) - change after import
INSERT IGNORE INTO users (id, fullname, username, password_hash, role_id, matricule, group_id)
VALUES (1, 'Administrator', 'admin', '$2y$10$wHq9sK0J1E2k9y0M8r1b9uN2q8aYkQeZfV6tQk1c5sP3t1wGZ6s5i', NULL, NULL);
-- note: the above hash corresponds to 'admin123' generated with password_hash -- change after import
