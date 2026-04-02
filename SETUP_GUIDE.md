# Rental Mobil - Setup & Installation Guide

## Prerequisites
- PHP 8.3+
- PostgreSQL 12+
- Composer
- Node.js 18+
- npm/yarn

## Installation Steps

### 1. Copy Environment File
```bash
cp .env.example .env
```

### 2. Update .env for PostgreSQL
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=rental_mobil
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 3. Install Dependencies
```bash
composer install
npm install
```

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Run Migrations
```bash
php artisan migrate --seed
```

### 6. Create Storage Link
```bash
php artisan storage:link
```

### 7. Compile Assets
```bash
npm run build
```

or for development:
```bash
npm run dev
```

## Development Server

Run all services concurrently:
```bash
composer run dev
```

Or separately:
```bash
# Terminal 1 - Laravel server
php artisan serve

# Terminal 2 - Vite dev server
npm run dev

# Terminal 3 - Queue listener
php artisan queue:listen

# Terminal 4 - Logs
php artisan pail
```

## Project Structure

```
app/
  ├── Models/              # Eloquent models
  ├── Http/
  │   ├── Controllers/     # Controllers
  │   └── Requests/        # Form requests
  ├── Services/            # Business logic
  ├── Repositories/        # Data access layer
  └── Jobs/                # Queue jobs

database/
  ├── migrations/          # Schema migrations
  ├── seeders/             # Database seeders
  └── factories/           # Model factories

resources/
  ├── views/               # Blade templates
  │   ├── public/          # Landing page
  │   ├── customer/        # Customer dashboard
  │   ├── admin/           # Admin dashboard
  │   └── components/      # Reusable components
  ├── css/                 # Tailwind config
  └── js/                  # Alpine.js

routes/
  ├── web.php              # Web routes
  ├── api.php              # API routes
  └── admin.php            # Admin routes
```

## Default Credentials

### Admin Account
- Email: admin@rental-mobil.local
- Password: password123

### Staff Account
- Email: staff@rental-mobil.local
- Password: password123

### Customer Account (Sample)
- Email: customer@rental-mobil.local
- Password: password123

## Payment Gateway Setup

### Midtrans
1. Get credentials from https://dashboard.midtrans.com
2. Add to .env:
```
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

### Xendit
1. Get credentials from https://dashboard.xendit.co
2. Add to .env:
```
XENDIT_API_KEY=your_api_key
XENDIT_WEBHOOK_TOKEN=your_webhook_token
```

## Build & Deployment

### Production Build
```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Nginx Configuration
See `nginx.conf` for production setup

### Deploy to VPS
```bash
git clone repository
cd rental-mobil
composer install --optimize-autoloader --no-dev
npm install
npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --force
php artisan storage:link
sudo chown -R www-data:www-data storage bootstrap/cache
sudo systemctl restart nginx php-fpm
```

## Support

For issues or questions, refer to:
- Laravel docs: https://laravel.com/docs
- Tailwind CSS: https://tailwindcss.com/docs
- PostgreSQL: https://www.postgresql.org/docs/
