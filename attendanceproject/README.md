# Attendance System - Demo Project

This repository contains a complete starter implementation for the *Web-Based Student Attendance Management System* described in the assignment.

## Contents
- `sql/schema.sql` - Database schema and seed data.
- `backend/` - PHP backend endpoints and config.
- `frontend/` - Simple demo HTML pages (professor, student, admin).
- `uploads/` - (generated at runtime) for file uploads.
- Original assignment and tutorial files included:
  - /mnt/data/Final_Assignment_Attendance_System.pdf
  - /mnt/data/Tutorial 3 AWP V1.pdf

## Quick Setup (Local, WAMP/XAMPP)
1. Copy the `attendance-project` folder into your Apache `htdocs` (or `www`) folder or run with PHP built-in server:
   ```
   php -S localhost:8000 -t /path/to/attendance-project
   ```
2. Create the database:
   - Using phpMyAdmin or MySQL client: `CREATE DATABASE attendance_db;`
   - Import `sql/schema.sql` into `attendance_db`.
3. Edit `backend/config.php` to set your DB credentials.
4. Ensure `uploads/` directory is writable by the web server.
5. Visit the site:
   - `http://localhost/attendance-project/frontend/`

## Demo accounts
- Admin: username `admin` (password `admin123`) - change after import
- Student: create via `backend/add_student.php` or directly in DB.

## GitHub
Initialize a repository and push:
```
git init
git add .
git commit -m "Initial project scaffold for attendance system"
git branch -M main
git remote add origin https://github.com/yourusername/attendance-project.git
git push -u origin main
```

## What to present to the teacher
See `presentation_script.txt` and `demo_script.txt` included in repository.

## Notes & Next steps
- This scaffold is intentionally minimal and focused on the required flows: create session, mark attendance, submit justification.
- For production use: add authentication, input validation, CSRF protection, stronger RBAC, file scan & size checks, and HTTPS.
