# Employee Manager — Simple PHP CRUD

A clean, beginner-friendly **PHP & MySQL CRUD (Create, Read, Update, Delete)** web application built with procedural `mysqli` and zero external dependencies. Designed as a hands-on learning project for **Software Developers** and **SQA (Software Quality Assurance) Engineers**.

---

## Features

- **Create**: Add a new employee record (`create.php`)
- **Read**: View all employees in a directory table (`index.php`) or view a single employee's full profile (`view.php`)
- **Update**: Edit existing employee details (`edit.php`)
- **Delete**: Remove an employee record (`delete.php`)
- **Environment Configuration**: Uses a `.env` file parsed natively with PHP (`parse_ini_file`) to keep database credentials separate from application logic.

---

## Project Structure

```text
simple_php_crud/
├── .env.example          # Example environment configuration file
├── .gitignore            # Git ignore rules
├── README.md             # Project documentation (this file)
├── assets/
│   └── style.css         # Stylesheet for layout, forms, tables, and buttons
├── config/
│   └── db.php            # Reads .env and connects to MySQL using mysqli
├── database/
│   └── schema.sql        # SQL script to create database, table, and sample data
├── includes/
│   ├── header.php        # Shared HTML header and top navigation bar
│   └── footer.php        # Shared HTML footer
├── index.php             # READ (All): Lists all employees
├── create.php            # CREATE: Form and logic to add a new employee
├── view.php              # READ (Single): Displays details of one employee
├── edit.php              # UPDATE: Form and logic to update an employee
└── delete.php            # DELETE: Deletes an employee by ID
```

---

## Prerequisites

- **XAMPP / WAMP / Laragon** (or standalone PHP & MySQL)
- **PHP** 7.4 or 8.x (with `mysqli` extension enabled)
- **MySQL / MariaDB** running on port `3306`

---

## Installation & Setup Guide

### 1. Place the Project in Your Web Server Directory
Clone or copy this folder into your XAMPP `htdocs` directory:
```text
D:\Software\xampp\htdocs\simple_php_crud
```

### 2. Configure the `.env` File
Copy `.env.example` to a new file named `.env` in the project root:
```bash
cp .env.example .env
```

Verify the database settings inside `.env`:
```ini
DB_HOST="127.0.0.1"
DB_PORT="3306"
DB_NAME="simple_php_crud"
DB_USER="root"
DB_PASS=""
```

### 3. Import the Database Schema
Start **Apache** and **MySQL** in the XAMPP Control Panel, then import `database/schema.sql` using either method below:

**Option A — Using phpMyAdmin:**
1. Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Click the **Import** tab in the top menu
3. Choose the file `database/schema.sql` and click **Import / Go**

**Option B — Using Command Line:**
```bash
mysql -u root -P 3306 < database/schema.sql
```

### 4. Run the Application
Open your browser and navigate to:
```text
http://localhost/simple_php_crud/
```

---

## How CRUD Works in This Project

| Operation | HTTP Method | File | SQL Query Executed |
| :--- | :--- | :--- | :--- |
| **Create** | `GET` / `POST` | `create.php` | `INSERT INTO employees (name, email, phone, role, salary) VALUES (...)` |
| **Read (All)** | `GET` | `index.php` | `SELECT * FROM employees ORDER BY id DESC` |
| **Read (Single)** | `GET` | `view.php?id={id}` | `SELECT * FROM employees WHERE id = {id}` |
| **Update** | `GET` / `POST` | `edit.php?id={id}` | `UPDATE employees SET name=..., email=..., phone=..., role=..., salary=... WHERE id = {id}` |
| **Delete** | `GET` | `delete.php?id={id}` | `DELETE FROM employees WHERE id = {id}` |

---

## Business Requirements & Field Specifications

When creating or updating an employee record, the application is expected to follow these rules:

| Field | Type | Required | Validation Rule |
| :--- | :--- | :--- | :--- |
| **Full Name** | Text | Yes | Must be between **3 and 50 characters** |
| **Email Address** | Email | Yes | Must be a **valid email format** (e.g., `name@example.com`) |
| **Phone Number** | Text | Yes | Must be **exactly 11 digits** (`0-9` only) |
| **Role / Department** | Dropdown | Yes | Must select a valid option (`Software Developer`, `SQA Engineer`, `UI/UX Designer`, `Project Manager`) |
| **Monthly Salary ($)** | Number | Yes | Must be a numeric value between **0 and 500,000** |

---

## Troubleshooting

- **`Database Connection Failed: Unknown database 'simple_php_crud'`**
  Make sure you imported `database/schema.sql` into MySQL.
- **`Error: .env file is missing`**
  Make sure you created `.env` in the root folder (copied from `.env.example`).
- **Connection Refused on Port 3306**
  Open the XAMPP Control Panel and confirm that **MySQL** is started and running on port `3306`.
