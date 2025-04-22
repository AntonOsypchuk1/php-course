<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Library Management System API

A Laravel-based RESTful API for managing a library, featuring:

- **Authors**, **Categories**, **Books**, **Loans**, **Reservations**, **Fines**, **Users**, **Roles**, **System Settings**
- **JWT authentication** for secure access
- **CRUD operations** on all resources
- **Filtering** & **pagination** on listings
- **Role-based** access (Admin, Assistant, Member)
- **Service layer** for clean architecture
- **Scheduled tasks** (cron) for overdue loan processing
- **Seeders** for initial data
- **Postman collection** for testing

## Table of Contents

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Environment Setup](#environment-setup)
4. [Database Setup](#database-setup)
5. [Migrations & Seeders](#migrations--seeders)
6. [Service Container Bindings](#service-container-bindings)
7. [Routing & Middleware](#routing--middleware)
8. [Scheduling & Cron](#scheduling--cron)
9. [Postman Collection](#postman-collection)
10. [Testing](#testing)
11. [Contributing](#contributing)
12. [License](#license)

## Requirements

- PHP 8.x
- Composer
- Laravel 12.x
- SQLite / MySQL (or preferred database)
- Node.js & npm (for front‑end scaffolding if needed)

## Installation

```bash
# Clone repo
git clone https://github.com/yourusername/library-management.git
cd library-management

# Install dependencies
composer install
```

## Environment Setup

1. Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   ```
2. Generate application key:
   ```bash
   php artisan key:generate
   ```
3. Configure database in `.env`:
   ```dotenv
   DB_CONNECTION=sqlite
   # DB_DATABASE=${PWD}/database/database.sqlite
   # or for MySQL:
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=library_management
   # DB_USERNAME=root
   # DB_PASSWORD=secret
   ```

## Database Setup

1. Run migrations (should automatically create a database.sqlite, if not create manualy):
   ```bash
   php artisan migrate
   ```
2. Seed initial data:
   ```bash
   php artisan db:seed
   ```

## Migrations & Seeders

- **Migrations** for tables: `roles`, `users`, `authors`, `categories`, `books`, `author_book`, `loans`, `reservations`, `fines`, `system_settings`.
- **Seeders**: `RoleSeeder`, `AuthorSeeder`, `CategorySeeder`, `BookSeeder`, `SystemSettingSeeder`, `UserSeeder`, `LoanSeeder`, `ReservationSeeder`, `FineSeeder`

## Service Container Bindings

Bindings in `app/Providers/AppServiceProvider.php`:
```php
$this->app->singleton(\App\Services\RoleService::class);
$this->app->singleton(\App\Services\UserService::class);
$this->app->singleton(\App\Services\AuthorService::class);
$this->app->singleton(\App\Services\CategoryService::class);
$this->app->singleton(\App\Services\BookService::class);
$this->app->singleton(\App\Services\LoanService::class);
$this->app->singleton(\App\Services\ReservationService::class);
$this->app->singleton(\App\Services\FineService::class);
$this->app->singleton(\App\Services\SystemSettingService::class);
```

## Routing & Middleware

- **API routes** live in `routes/api.php`.
- **Public**: `POST /api/auth/register`, `POST /api/auth/login`.
- **Protected**: All other resources under `jwt.auth`.
- Middleware alias and registration in `bootstrap/app.php`:
  ```php
  ->withMiddleware(function (Middleware $middleware) {
      $middleware->alias([
          'jwt.auth' => JWTAuthenticate::class,
      ]);
  })
  ```

## Postman Collection

Import `postman_collection.json` in `/docs` or root. Includes:
- Auth: Register, Login
- CRUD for all resources
- Test scripts for status codes, data validation
- Environment variables: `base_url`, `token`

### Postman

- Use Collection Runner to execute all endpoint tests.
- Ensure `{{token}}` is set after login.

## License

MIT © Anton Osypchuk
