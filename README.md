# Event Management System

A PHP-based event management system that allows users to create, manage, and track events efficiently.

---

## 📌 System Requirements
- **PHP 8.3 or higher**  
- **Apache Server** (XAMPP, LAMP, or a standalone Apache server)  
- **MySQL Database**  
- **PDO Extension** (Enabled in `php.ini`)  

---

## 🚀 Installation Guide

### 1️⃣ Install XAMPP (For Local Development)
1. Download **XAMPP** from [Apache Friends](https://www.apachefriends.org/download.html).
2. Install and run **Apache** and **MySQL** from the XAMPP Control Panel.
3. Place the project inside the `htdocs` folder, e.g.:

### 2️⃣ Database Setup
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Create a new databas
3. Import the `database.sql` file from this project.

### 3️⃣ Configure Database Connection
Edit the database connection in `config.php`:

```
define('DB_HOST', 'localhost');
define('DB_NAME', 'event_management'); // set your database name
define('DB_USER', 'root'); // set your database username
define('DB_PASS', ''); // set your database password
```

### admin panel user id
Email: admin@mail.com
Password: 121314


