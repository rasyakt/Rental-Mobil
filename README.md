# 🚗 Rental Mobil - Sistem Manajemen Rental Kendaraan Modern

Aplikasi web full-stack profesional untuk manajemen rental mobil dengan fitur booking online, pembayaran, tracking kendaraan, dan management lengkap.

## 📋 Daftar Isi
1. [Fitur Utama](#fitur-utama)
2. [Teknologi](#teknologi)
3. [Instalasi](#instalasi)
4. [Struktur Proyek](#struktur-proyek)
5. [Panduan Penggunaan](#panduan-penggunaan)
6. [API Reference](#api-reference)
7. [Database Schema](#database-schema)

---

## ✨ Fitur Utama

### 👥 Manajemen Pengguna
- **Authentikasi**: Registrasi, login, password reset
- **Role-Based Access Control**: Admin, Staff, Customer
- **Profile Management**: Edit profil, ubah password
- **Multi-Branch Support**: User dapat diassign ke branch tertentu

### 🚗 Manajemen Kendaraan
- **CRUD Kendaraan**: Tambah, edit, hapus, lihat detail kendaraan
- **Kategori Kendaraan**: Ekonomi, Standar, Premium, SUV, MPV, Mewah
- **Multi-Photo Upload**: Upload multiple foto kendaraan per vehicle
- **Fitur Kendaraan**: Tambah fasilitas/amenities untuk setiap kendaraan
- **Status Tracking**: Available, Rented, Maintenance, Inactive
- **Pricing Management**: Harga harian, mingguan, bulanan + harga sopir

### 👨‍✈️ Manajemen Sopir
- **Database Sopir**: Kelola data sopir dengan SIM dan lisensi
- **Jadwal Sopir**: Manage availability dan jadwal kerja
- **Rating System**: Penilaian dari pelanggan
- **Status Tracking**: Available, On-duty, On-leave, Inactive

### 📅 Sistem Booking
- **Online Booking**: Pelanggan dapat booking 24/7
- **Availability Check**: Cek otomatis ketersediaan kendaraan
- **Durasi Fleksibel**: Harian, mingguan, bulanan
- **Opsi Sopir**: Booking dengan atau tanpa sopir
- **Automatic Pricing**: Kalkulasi harga otomatis
- **Status Management**: Pending → Confirmed → Active → Completed

### 💳 Sistem Pembayaran
- **Multiple Gateway**: Midtrans, Xendit, Bank Transfer, QRIS, E-wallet
- **Secure Payment**: Enkripsi dan validasi pembayaran
- **Invoice Generation**: Buat invoice otomatis
- **Refund Management**: Proses pengembalian dana
- **Payment History**: Riwayat pembayaran pelanggan

### 📍 Kendaraan Tracking
- **Real-time GPS Tracking**: Lokasi kendaraan realtime
- **Route Logging**: Catat riwayat perjalanan
- **Map Visualization**: Tampilkan di Google Maps
- **Speed Monitoring**: Monitor kecepatan perjalanan

### 🛠️ Maintenance Management
- **Service Schedule**: Jadwal service berkala
- **Damage Reporting**: Lapor kerusakan dengan foto
- **Cost Tracking**: Catat biaya maintenance
- **Status Monitoring**: Scheduled → In Progress → Completed

### 📊 Reporting & Analytics
- **Revenue Reports**: Laporan pendapatan per periode
- **Booking Analytics**: Statistik booking dan utilisasi
- **Vehicle Utilization**: Laporan penggunaan kendaraan
- **Driver Performance**: Performa sopir dan rating
- **Export Features**: Download laporan PDF/Excel

### 🎯 Fitur Tambahan
- **Promosi & Voucher**: Buat dan kelola kode diskon
- **Dark Mode**: Tema gelap untuk tampilan yang nyaman
- **Multi-Language**: Dukungan bahasa Indonesia dan Inggris
- **Notification System**: Email, SMS, WhatsApp, In-app
- **Audit Logging**: Catat semua aktivitas pengguna
- **API Logging**: Monitor semua request API

---

## 🛠️ Teknologi

### Backend
- **Framework**: Laravel 13.0
- **PHP**: 8.3+
- **Database**: PostgreSQL 12+
- **Authentication**: Laravel Breeze
- **Authorization**: Role-Based Permissions

### Frontend
- **CSS Framework**: Tailwind CSS 4.0
- **JavaScript**: Alpine.js
- **Templating**: Blade Templates
- **Build Tool**: Vite
- **Icons**: Font Awesome (optional)

### Infrastructure
- **Cache**: Database/Redis
- **Queue**: Database
- **Session**: Database
- **File Storage**: Local/S3
- **Email**: SMTP/Mailgun

### External Services
- **Payment**: Midtrans, Xendit
- **Mapping**: Google Maps API
- **Notification**: Twilio (WhatsApp), SendGrid (Email)
- **Image Processing**: ImageMagick/GD

---

## 📦 Instalasi

### Prerequisites
- PHP 8.3+
- PostgreSQL 12+
- Composer
- Node.js 18+
- npm/yarn

### Step-by-Step Setup

#### 1. Clone Repository
```bash
git clone <repository-url>
cd rental-mobil
```

#### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

#### 3. Update .env untuk PostgreSQL
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=rental_mobil
DB_USERNAME=postgres
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password

# Payment Gateway
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false

XENDIT_API_KEY=your_api_key
XENDIT_WEBHOOK_TOKEN=your_webhook_token

# Google Maps
GOOGLE_MAPS_API_KEY=your_api_key
```

#### 4. Install Dependencies
```bash
composer install
npm install
```

#### 5. Database Setup
```bash
php artisan migrate --seed
php artisan storage:link
```

#### 6. Compile Assets
```bash
npm run build
# or for development:
npm run dev
```

#### 7. Start Services
```bash
# Terminal 1 - Laravel Server
php artisan serve

# Terminal 2 - Node Watcher
npm run dev

# Terminal 3 - Queue (Optional)
php artisan queue:listen

# Or all in one:
composer run dev
```

### Akun Testing Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@rental-mobil.id | password123 |
| Staff | staff@rental-mobil.id (atau eka.putri@rental-mobil.id) | password123 |
| Customer | agus.hermanto@example.com | password123 |

---

## 📁 Struktur Proyek

```
rental-mobil/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Application Controllers
│   │   │   ├── AuthController.php
│   │   │   ├── Admin/            # Admin Controllers
│   │   │   ├── Customer/         # Customer Controllers
│   │   │   └── Public/           # Public Controllers
│   │   ├── Middleware/           # Route Middleware
│   │   └── Requests/             # Form Requests Validation
│   ├── Models/                   # Eloquent Models
│   │   ├── User.php
│   │   ├── Vehicle.php
│   │   ├── Booking.php
│   │   ├── Payment.php
│   │   ├── Driver.php
│   │   ├── Branch.php
│   │   ├── Role.php
│   │   └── ...
│   ├── Services/                 # Business Logic Services
│   │   ├── BookingService.php
│   │   ├── PaymentService.php
│   │   └── ...
│   ├── Repositories/             # Data Access Layer (Optional)
│   └── Providers/
├── database/
│   ├── migrations/               # Database Migrations
│   ├── seeders/                  # Database Seeders
│   └── factories/                # Model Factories
├── resources/
│   ├── views/                    # Blade Templates
│   │   ├── layout.blade.php      # Main Layout
│   │   ├── auth/                 # Auth Views
│   │   ├── public/               # Public Pages
│   │   ├── customer/             # Customer Dashboard
│   │   └── admin/                # Admin Dashboard
│   ├── css/
│   │   └── app.css               # Tailwind Config
│   └── js/
│       └── app.js                # Alpine.js Setup
├── routes/
│   ├── web.php                   # Web Routes
│   ├── api.php                   # API Routes (Optional)
│   └── console.php               # Artisan Commands
├── config/
│   ├── auth.php                  # Authentication Config
│   ├── cache.php
│   ├── database.php              # Database Config
│   ├── mail.php
│   └── services.php              # Third-party Services Config
├── public/
│   ├── index.php                 # Entry Point
│   └── storage/                  # Symlinked Storage
├── storage/                      # File Storage
│   ├── app/
│   │   ├── private/
│   │   └── public/
│   ├── logs/
│   └── ...
├── tests/                        # Unit & Feature Tests
├── .env.example                  # Environment Example
├── artisan                       # Artisan CLI
├── composer.json
├── package.json
├── vite.config.js
└── README.md
```

---

## 💻 Panduan Penggunaan

### Untuk Customer

1. **Registrasi & Login**
   - Klik "Daftar" di homepage
   - Isi data pribadi (nama, email, phone)
   - Verifikasi email (optional)
   - Login dengan email dan password

2. **Mencari Kendaraan**
   - Lihat daftar kendaraan di "Armada"
   - Filter berdasarkan kategori, harga, transmisi
   - Klik "Lihat Detail" untuk info lengkap

3. **Membuat Booking**
   - Pilih kendaraan dan klik "Pesan Sekarang"
   - Isi tanggal pickup dan return
   - Pilih dengan sopir atau tidak
   - Masukkan alamat pengambilan
   - Review harga dan klik "Pesan"

4. **Pembayaran**
   - Pilih metode pembayaran
   - Ikuti proses pembayaran di gateway
   - Booking akan otomatis confirmed setelah pembayaran sukses

5. **Manage Booking**
   - Lihat riwayat booking di Dashboard
   - Lihat detail booking, include driver info, pickup location
   - Batalkan booking jika diperlukan (sebelum konfirmasi)

### Untuk Admin/Staff

1. **Dashboard**
   - Lihat statistik keseluruhan
   - Monitoring booking dan revenue
   - Akses semua management module

2. **Manajemen Kendaraan**
   - Tambah kendaraan baru
   - Upload photo kendaraan
   - Atur pricing (daily/weekly/monthly)
   - Set status kendaraan
   - Monitor km dan next service

3. **Manajemen Sopir**
   - Kelola data sopir
   - Upload foto sopir
   - Set jadwal kerja
   - Monitor rating dan performa
   - Assign ke booking

4. **Manajemen Booking**
   - View semua booking
   - Confirm atau reject booking pending
   - Assign sopir ke booking
   - Mark sebagai active/completed
   - Generate invoice

5. **Pembayaran**
   - View payment status
   - Verify manual payment
   - Process refund jika ada complain

6. **Maintenance**
   - Create maintenance schedule
   - Track maintenance history
   - Report damage dengan foto
   - Monitor biaya maintenance

7. **Laporan**
   - Revenue report per period
   - Booking analytics
   - Vehicle utilization
   - Driver performance
   - Export to PDF/Excel

---

## 🔌 API Reference

### Public Routes
```
GET    /                           # Landing Page
GET    /vehicles                   # Daftar Kendaraan
GET    /vehicle/{id}              # Detail Kendaraan
GET    /branches                  # Daftar Cabang
GET    /faq                       # FAQ
GET    /about                     # About Page
GET    /contact                   # Contact Form
```

### Authentication Routes
```
POST   /register                  # Register
GET    /login                     # Login Form
POST   /login                     # Login Submit
POST   /logout                    # Logout
```

### Customer Routes
```
GET    /dashboard                           # Dashboard
GET    /dashboard/vehicles                  # Lihat Armada
GET    /dashboard/bookings                  # Daftar Booking
POST   /dashboard/bookings                  # Create Booking
GET    /dashboard/bookings/{id}            # Detail Booking
POST   /dashboard/bookings/{id}/cancel     # Cancel Booking
GET    /dashboard/payments                  # Daftar Pembayaran
POST   /dashboard/payments/process         # Proses Pembayaran
POST   /dashboard/payments/midtrans-callback  # Midtrans Webhook
GET    /dashboard/profile                   # Edit Profile
PUT    /dashboard/profile                   # Update Profile
PUT    /dashboard/profile/password         # Update Password
```

### Admin Routes
```
GET    /admin                              # Dashboard
GET    /admin/vehicles                     # List Vehicles
POST   /admin/vehicles                     # Create Vehicle
PUT    /admin/vehicles/{id}               # Update Vehicle
DELETE /admin/vehicles/{id}               # Delete Vehicle
POST   /admin/vehicles/{id}/upload-images # Upload Images
DELETE /admin/vehicles/{id}/images/{imageId} # Delete Image
POST   /admin/vehicles/{id}/change-status # Change Status

GET    /admin/drivers                      # List Drivers
POST   /admin/drivers                      # Create Driver
PUT    /admin/drivers/{id}                # Update Driver
DELETE /admin/drivers/{id}                # Delete Driver
POST   /admin/drivers/{id}/change-status  # Change Status
GET    /admin/drivers/{id}/schedule       # View Schedule
POST   /admin/drivers/{id}/schedule       # Update Schedule

GET    /admin/bookings                     # List Bookings
GET    /admin/bookings/{id}               # Detail Booking
PUT    /admin/bookings/{id}               # Update Booking
POST   /admin/bookings/{id}/confirm       # Confirm Booking
POST   /admin/bookings/{id}/assign-driver # Assign Driver
POST   /admin/bookings/{id}/complete      # Complete Booking
GET    /admin/bookings/{id}/invoice       # Generate Invoice

GET    /admin/payments                     # List Payments
GET    /admin/payments/{id}               # Detail Payment
POST   /admin/payments/{id}/verify        # Verify Payment
POST   /admin/payments/{id}/refund        # Process Refund

GET    /admin/branches                     # List Branches
POST   /admin/branches                     # Create Branch
PUT    /admin/branches/{id}               # Update Branch
DELETE /admin/branches/{id}               # Delete Branch

GET    /admin/maintenance                  # List Maintenance
POST   /admin/maintenance                  # Create Maintenance
PUT    /admin/maintenance/{id}            # Update Maintenance
POST   /admin/maintenance/{id}/complete   # Complete Maintenance

GET    /admin/reports                     # Reports Dashboard
GET    /admin/reports/revenue             # Revenue Report
GET    /admin/reports/bookings            # Booking Report
GET    /admin/reports/vehicles            # Vehicle Report
POST   /admin/reports/export              # Export Report
```

---

## 🗄️ Database Schema

### Core Tables

#### users
```sql
id | name | email | phone | photo_path | user_type | branch_id | 
address | city | postal_code | is_active | last_login_at | 
password | email_verified_at | remember_token | created_at | updated_at | deleted_at
```

#### roles & permissions
```sql
roles:
  id | name | display_name | description | created_at | updated_at

permissions:
  id | name | display_name | description | created_at | updated_at

role_permissions:
  id | role_id | permission_id | created_at | updated_at

user_roles:
  id | user_id | role_id | created_at | updated_at
```

#### branches
```sql
id | name | slug | address | city | province | postal_code | phone | 
email | latitude | longitude | opening_hour | closing_hour | is_active | 
notes | created_at | updated_at | deleted_at
```

#### vehicles
```sql
id | branch_id | category_id | plat_number | brand | model | year | color | 
seat_capacity | transmission | fuel_type | price_daily | price_weekly | 
price_monthly | price_driver_daily | status | total_km | last_service_date | 
service_interval_km | notes | created_at | updated_at | deleted_at
```

#### bookings
```sql
id | booking_number | customer_id | vehicle_id | driver_id | pickup_branch_id | 
return_branch_id | pickup_date | return_date | rental_type | with_driver | 
pickup_address | return_address | total_price | tax | additional_charges | 
discount | final_price | status | notes | admin_notes | 
created_at | updated_at | deleted_at
```

#### payments
```sql
id | payment_number | booking_id | amount | payment_method | status | 
transaction_id | reference_number | payment_details | paid_at | failure_reason | 
created_at | updated_at | deleted_at
```

---

## 🚀 Deployment

### Prerequisites
- Ubuntu 20.04 LTS server
- Nginx web server
- PostgreSQL 12+
- Supervisor for queue management

### Production Deployment Steps

```bash
# Clone repository ke /var/www/rental-mobil
cd /var/www/rental-mobil

# Setup environment
cp .env.example .env
# Edit .env dengan production settings

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install --production
npm run build

# Database
php artisan migrate --force
php artisan db:seed --class=RolePermissionSeeder

# Cache & Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# File permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Nginx configuration
# Copy nginx.conf.example ke /etc/nginx/sites-available/rental-mobil
# Update domain dan paths sesuai

# SSL Certificate (Let's Encrypt)
sudo certbot --nginx -d rental-mobil.id -d www.rental-mobil.id

# Supervisor for queue
# Copy supervisor.conf.example ke /etc/supervisor/conf.d/
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start all

# Start services
sudo systemctl restart nginx
sudo systemctl start php8.3-fpm
```

---

## 📝 Maintenance & Updates

### Regular Tasks
- Monitor disk space, database size
- Backup database daily
- Check error logs
- Update dependencies monthly
- Clean old logs and temp files

### Useful Commands

```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Database
php artisan migrate:rollback      # Rollback migrations
php artisan tinker                # Laravel REPL
php artisan db:seed --class=Seeder # Run specific seeder

# Maintenance mode
php artisan down --message "Maintenance"
php artisan up

# Queue
php artisan queue:listen          # Listen for jobs
php artisan queue:work            # Process jobs
php artisan queue:failed          # Check failed jobs
php artisan queue:retry all       # Retry failed jobs
```

---

## 🤝 Contributing

Kontribusi sangat diterima! Silakan:
1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📄 License

Distributed under the MIT License. See LICENSE file for more information.

---

## 📞 Support & Contact

- 📧 Email: info@rental-mobil.id
- 📱 WhatsApp: (021) 123-4567
- 🌐 Website: https://rental-mobil.id

---

**Made with ❤️ by Antigravity Development Team**

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
