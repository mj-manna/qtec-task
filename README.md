# Service Booking System (Generate By AI)

A modern full-stack service booking application built with **Laravel 12** and **React 19**, featuring a clean API, role-based access control, and a responsive user interface.

## 🔗 Project Links
- 🌐 [Live Server](https://qtec-task.doracone.com)
- 📁 [Repository](https://github.com/mj-manna/qtech-task)
- 🚀 [Postman API Documentation](https://documenter.getpostman.com/view/26294663/2sB3B8tDZY)
- 📘 [Swagger API Documentation](https://qtec-task.doracone.com/api/documentation#/)

## 🏗️ Architecture Overview

- **Backend**: Laravel 12 with Inertia.js for seamless SPA experience
- **Frontend**: React 19 + TypeScript with Tailwind CSS and Radix UI
- **Authentication**: Laravel Sanctum for API token management
- **Database**: SQLite (default) with support for MySQL/PostgreSQL
- **API Documentation**: Swagger with l5-swagger & Postman Collection
- **Testing**: PHPUnit for backend, comprehensive feature tests

## ✨ Features

### Core Functionality
- **Service Management**: CRUD operations for services (admin only)
- **Booking System**: Users can book available services
- **Role-Based Access**: Admin and customer roles with appropriate permissions
- **Authentication**: Complete auth flow (register, login, password reset, email verification)
- **API Endpoints**: RESTful API for external integrations

### User Roles
- **Admin**: Manage services, view all bookings, access admin dashboard
- **Customer**: Browse services, create bookings, manage personal bookings

### Frontend Features
- Server-side rendering (SSR) support
- Responsive design with mobile-first approach
- Modern UI components using Radix UI primitives
- Dark/light mode theming
- Type-safe development with TypeScript

## 🚀 Quick Start

### Prerequisites

- **PHP** >= 8.2
- **Node.js** >= 18.x
- **Composer** >= 2.x
- **SQLite** (default) or MySQL/PostgreSQL

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/mj-manna/qtech-task.git
   cd qtech-task
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env  # If .env.example exists, otherwise configure manually
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   # SQLite (default - no additional setup needed)
   touch database/database.sqlite
   
   # Or configure MySQL/PostgreSQL in .env:
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=your_database
   # DB_USERNAME=your_username
   # DB_PASSWORD=your_password
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Generate API documentation**
   ```bash
   php artisan l5-swagger:generate
   ```

### Development Workflow

#### Option 1: One Command Development (Recommended)
```bash
composer dev
```
This starts all development services concurrently:
- Laravel development server (http://localhost:8000)
- Log monitoring (Pail)
- Vite dev server for hot module replacement

#### Option 2: Manual Development Setup
```bash
# Terminal 1: Backend server
php artisan serve

# Terminal 2: Frontend build process
npm run dev

# Terminal 4: Real-time logs (optional)
php artisan pail
```

### Production Build

```bash
# Build frontend assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start production server
php artisan serve --env=production
```

## 🧪 Testing

### Run All Tests
```bash
composer test
# or
php artisan test
```

### Run Specific Test Suites
```bash
# Service functionality
php artisan test tests/Feature/ServiceTest.php

# Booking functionality  
php artisan test tests/Feature/BookingTest.php

# Authentication flow
php artisan test tests/Feature/Auth/
```


## 📚 API Documentation

### Access Swagger Documentation
Visit `/api/documentation` when the application is running to explore the API endpoints interactively.

### Key API Endpoints

#### Authentication
- `POST /api/register` - User registration
- `POST /api/login` - User login  
- `POST /api/logout` - User logout (authenticated)

#### Services
- `GET /api/services` - List all active services (authenticated)
- `POST /api/services` - Create service (admin only)
- `PUT /api/services/{id}` - Update service (admin only)
- `DELETE /api/services/{id}` - Delete service (admin only)

#### Bookings
- `GET /api/bookings` - User's bookings (authenticated)
- `POST /api/bookings` - Create booking (authenticated)
- `GET /api/admin/bookings` - All bookings (admin only)

## 🗄️ Database Schema

### Core Tables

**users**
- Standard Laravel user fields + role management

**services**  
- `name`: Service title
- `description`: Detailed service description
- `price`: Service cost (decimal)
- `status`: active/inactive enum

**bookings**
- `user_id`: Foreign key to users
- `service_id`: Foreign key to services  
- `booking_date`: Date of service
- `status`: pending/confirmed/cancelled enum


## 🛠️ Development Tips

### Useful Commands

```bash
# Clear all caches during development
php artisan optimize:clear

# Reset database with fresh migrations
php artisan migrate:fresh --seed

```

## 🐛 Troubleshooting

### Common Issues

**Database connection errors**
```bash
# Ensure SQLite file exists and is writable
touch database/database.sqlite
chmod 664 database/database.sqlite
```

**Asset compilation issues**
```bash
# Clear Vite cache
rm -rf node_modules/.vite
npm run dev
```

**Permission errors**
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
```

**API documentation not generating**
```bash
# Regenerate Swagger docs
php artisan l5-swagger:generate
```