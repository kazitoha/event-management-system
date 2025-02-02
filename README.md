# Event Management System

**Project Overview**  
This project is an event management system where users can create, update, delete, and manage events. It includes features such as attendee registration, event search, and a JSON API.  
A PHP-based event management system that allows users to create, manage, and track events efficiently.

---

## 🌐 Live Demo

You can view a live demo of this project at the following link:  
[Live Demo of Event Management System](https://your-live-demo-url.com)

---

## Features

1. Create, update, and delete events.
2. Attendee registration with AJAX.
3. Search functionality across events and attendees.
4. JSON API to fetch event details.

---

## 📌 System Requirements
- **PHP 8.3 or higher**  
- **Apache Server** (XAMPP, LAMP, or a standalone Apache server)  
- **MySQL Database**  
- **PDO Extension** (Enabled in `php.ini`)  

---


## 🚀 Environment Setup Guide
### 1️⃣ Install XAMPP (For Local Development)
1. Download **XAMPP** from [Apache Friends](https://www.apachefriends.org/download.html).
2. Install and run **Apache** and **MySQL** from the XAMPP Control Panel.
3. Place the project inside the `htdocs` folder, e.g.:

##  2️⃣ Project Installation Guide
1. Clone the repository: ``` git clone https://github.com/yourusername/event-management.git ```
2. Navigate to the project directory: ```cd event-management```

### 3️⃣ Database Setup
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Create a new databas
3. Import the `database.sql` file from this project.

### 4️⃣ Configure Database Connection
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


## 📡 JSON API Details

The Event Management System provides a JSON API that allows you to interact with event data programmatically.

### API Endpoints
1. **Get All Events**
   - **Endpoint**: `/api/`
   - **Method**: GET
   - **Description**: Retrieves all events from the database.
   - **Example Request**:
     ```
     GET http://localhost/event-management-system/api/?action=list
     ```

2. **Get Event by ID**
   - **Endpoint**: `/api/`
   - **Method**: GET
   - **Description**: Retrieves a specific event by its ID.
   - **Example Request**:
     ```
     GET http://localhost/event-management/api/?action=view&id=4
     ```