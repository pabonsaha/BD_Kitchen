<div align="center">

# 🍽️ BD Kitchen

### Multi-Vendor Food Ordering Platform

A full-stack food ordering marketplace built with Laravel and Vue.js, enabling restaurants and independent food vendors to register, showcase their menus, and serve customers through a centralized ordering platform.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge\&logo=laravel\&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-4FC08D?style=for-the-badge\&logo=vuedotjs\&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge\&logo=bootstrap\&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge\&logo=javascript\&logoColor=black)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge\&logo=mysql\&logoColor=white)

</div>

---

## 📖 Overview

BD Kitchen is a multi-vendor food ordering platform that connects customers with restaurants and independent food sellers. Vendors can register their businesses, manage menus, receive orders, and serve customers through a unified marketplace.

Customers can browse food items from multiple vendors, place orders, and enjoy a seamless online food ordering experience.

The platform includes a comprehensive administrative backend for managing vendors, customers, products, orders, and platform activities.

---

## ✨ Features

### 👨‍🍳 Vendor Features

* Vendor Registration & Authentication
* Restaurant & Home Chef Registration
* Menu Management
* Product Management
* Order Management
* Profile Management
* Dashboard Analytics
* Inventory Updates

### 🛒 Customer Features

* User Registration & Login
* Browse Food Categories
* Search Food Items
* Add to Cart
* Place Orders
* Order Tracking
* Order History
* Responsive User Experience

### 🛠️ Admin Features

* Admin Dashboard
* Vendor Management
* Customer Management
* Product Management
* Category Management
* Order Monitoring
* User Management
* Platform Analytics

---

## 🚀 Technology Stack

### Backend

* Laravel
* PHP
* MySQL
* Eloquent ORM

### Frontend

* Vue.js
* Bootstrap
* JavaScript
* Axios

### Development Tools

* Laravel Authentication
* Laravel Migrations
* Laravel Seeders
* Git & GitHub

---

## 🎯 Core Modules

### 🍴 Vendor Management

* Vendor Registration
* Business Profile Setup
* Menu Management
* Product Listings
* Order Processing

### 🛍️ Customer Management

* Account Creation
* Shopping Cart
* Food Browsing
* Order Placement
* Order Tracking

### 📦 Order Management

* Order Processing
* Order Status Updates
* Order History
* Customer Notifications

### 📊 Administration

* Vendor Approval
* Product Oversight
* User Management
* Reporting & Analytics

---

## ⚙️ Installation

### Clone Repository

```bash
git clone https://github.com/pabonsaha/BD_Kitchen.git
cd BD_Kitchen
```

### Install Dependencies

```bash
composer install
npm install
```

### Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database credentials in the `.env` file:

```env
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Run Database Migrations

```bash
php artisan migrate
```

### Seed Database (Optional)

```bash
php artisan db:seed
```

### Build Frontend Assets

```bash
npm run dev
```

For production:

```bash
npm run build
```

### Start Application

```bash
php artisan serve
```

Application URL:

```text
http://127.0.0.1:8000
```

---

## 📂 Project Structure

```text
app/
├── Http/
├── Models/
├── Services/

database/
├── migrations/
├── seeders/

resources/
├── js/
├── views/

routes/
├── web.php
├── api.php

public/
```

---

## 🔒 Security Features

* Authentication & Authorization
* CSRF Protection
* Form Validation
* Password Hashing
* Role-Based Access Control

---

## 🔮 Future Enhancements

* Online Payment Integration
* Real-Time Order Tracking
* Delivery Management System
* Vendor Subscription Plans
* Customer Reviews & Ratings
* Push Notifications
* Mobile Application
* Advanced Analytics Dashboard

---

## 👨‍💻 Author

**Pabon Saha**

Full-Stack Web Developer

* GitHub: https://github.com/pabonsaha

---

## 📄 License

This project is developed for educational and commercial purposes.
