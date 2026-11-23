# POS Management System (Laravel 12)

A Laravel MVC point-of-sale starter application with staff authentication, product/customer/staff management, image uploads, stock-safe sales, and sales history.

## Requirements
- PHP 8.2+
- Composer 2
- MySQL 8+ (or MariaDB)
- Node.js is not required for this Bootstrap-CDN starter UI.

## Installation
1. Extract this project.
2. Run `composer install`.
3. Copy `.env.example` to `.env` and configure the database.
4. Create a MySQL database named `pos_management` (or use your configured name).
5. Run:
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   php artisan serve
   ```
6. Visit `http://127.0.0.1:8000`.

## Demo account
- Email: `admin@gmail.com`
- Password: `password`

Change the demo password immediately in any non-local environment. The seeder creates this account only for local/demo use.

## Main features
- Session-based login/logout; all POS routes require authentication.
- Product CRUD with image upload and stock quantity.
- Customer CRUD.
- Staff CRUD with avatar upload and hashed passwords.
- Sales form with optional customer selection.
- Stock validation and atomic sale/inventory update using a database transaction and row lock.
- Sales history with product, customer, staff, quantity, total, and timestamp.

## MVC layout
- `app/Models`: Product, Customer, Sale, User
- `app/Http/Controllers`: authentication and resource controllers
- `resources/views`: Blade templates
- `routes/web.php`: web routes and auth middleware
- `database/migrations`: relational schema
- `database/seeders`: demo staff account

## Deployment checklist
1. Provision PHP 8.2+, Composer, and MySQL.
2. Set production `.env`: `APP_ENV=production`, `APP_DEBUG=false`, correct `APP_URL`, DB credentials, and a secure generated `APP_KEY`.
3. Run `composer install --no-dev --optimize-autoloader`.
4. Run `php artisan migrate --force`.
5. Run `php artisan storage:link`.
6. Ensure `storage` and `bootstrap/cache` are writable.
7. Configure the web server document root to the project's `public/` directory.
8. Run `php artisan config:cache && php artisan route:cache && php artisan view:cache`.
9. Remove/disable demo credentials and create unique staff accounts.

