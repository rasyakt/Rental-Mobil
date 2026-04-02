# 🚀 Rental Mobil - Deployment Guide

Panduan lengkap untuk deploy Rental Mobil ke production server.

## 📋 Table of Contents

1. [Prerequisites](#prerequisites)
2. [Server Setup](#server-setup)
3. [Application Deployment](#application-deployment)
4. [Database Setup](#database-setup)
5. [Web Server Configuration](#web-server-configuration)
6. [SSL/HTTPS Setup](#ssltls-setup)
7. [Performance Optimization](#performance-optimization)
8. [Monitoring & Maintenance](#monitoring--maintenance)
9. [Backup & Recovery](#backup--recovery)
10. [Troubleshooting](#troubleshooting)

---

## ✅ Prerequisites

### Server Requirements

- **OS**: Ubuntu 20.04 LTS atau 22.04 LTS
- **CPU**: Minimum 2 cores (4 cores recommended)
- **RAM**: Minimum 2GB (4GB recommended)
- **Storage**: Minimum 20GB SSD
- **Bandwidth**: Minimum 1Mbps

### Required Software

- PHP 8.3+ dengan extensions: pgsql, bcmath, json, xml, mbstring, openssl
- PostgreSQL 12+ atau 13+
- Nginx atau Apache
- Node.js 18+ dengan npm
- Git
- Composer
- Supervisor (untuk queue management)
- Redis (optional, untuk caching)

---

## 🖥️ Server Setup

### 1. SSH Access Setup

```bash
# Generate SSH key (on your local machine)
ssh-keygen -t rsa -b 4096 -f ~/.ssh/rental-mobil-key

# Copy public key ke server
ssh-copy-id -i ~/.ssh/rental-mobil-key.pub deployer@your-server.com

# Setup SSH config
cat >> ~/.ssh/config <<EOF
Host rental-mobil
    HostName your-server.com
    User deployer
    IdentityFile ~/.ssh/rental-mobil-key
    StrictHostKeyChecking no
EOF

# Login
ssh rental-mobil
```

### 2. System Update & Dependencies

```bash
# Login ke server
ssh rental-mobil

# Update system
sudo apt update && sudo apt upgrade -y

# Install essential packages
sudo apt install -y build-essential software-properties-common curl gnupg2 \
    git unzip zip htop net-tools wget

# Install PHP 8.3
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install -y php8.3 php8.3-cli php8.3-fpm php8.3-pgsql \
    php8.3-bcmath php8.3-json php8.3-xml php8.3-mbstring php8.3-openssl \
    php8.3-curl php8.3-gd php8.3-zip php8.3-intl php8.3-dev

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Install PostgreSQL
sudo apt install -y postgresql postgresql-contrib

# Install Node.js LTS
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs

# Install Nginx
sudo apt install -y nginx

# Install Supervisor (for queue management)
sudo apt install -y supervisor

# Install Redis (optional but recommended)
sudo apt install -y redis-server

# Start services
sudo systemctl start php8.3-fpm
sudo systemctl start postgresql
sudo systemctl start redis-server
sudo systemctl start nginx

# Enable on boot
sudo systemctl enable php8.3-fpm postgresql redis-server nginx
```

### 3. Create Application User

```bash
# Create deployer user
sudo useradd -m -s /bin/bash deployer
sudo usermod -aG sudo deployer

# Switch to deployer
su - deployer

# Create SSH directory
mkdir -p ~/.ssh
chmod 700 ~/.ssh
```

### 4. Configure PostgreSQL

```bash
# Login ke PostgreSQL
sudo su - postgres
psql

# Create database dan user
CREATE DATABASE rental_mobil;
CREATE USER rental_user WITH PASSWORD 'your_strong_password_here';

# Grant permissions
ALTER ROLE rental_user SET client_encoding TO 'utf8';
ALTER ROLE rental_user SET default_transaction_isolation TO 'read committed';
ALTER ROLE rental_user SET default_transaction_deferrable TO on;
GRANT ALL PRIVILEGES ON DATABASE rental_mobil TO rental_user;

# Exit
\q
exit

# Verify connection
psql -U rental_user -d rental_mobil -h localhost
\q
```

---

## 📦 Application Deployment

### 1. Clone Repository

```bash
# Create web directories
sudo mkdir -p /var/www
sudo chown -R deployer:deployer /var/www
cd /var/www

# Clone repository
git clone https://github.com/your-repo/rental-mobil.git
cd rental-mobil

# Checkout to main/production branch
git checkout main
git pull origin main
```

### 2. Install Dependencies

```bash
cd /var/www/rental-mobil

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install NPM dependencies
npm install --production

# Build assets
npm run build
```

### 3. Configure Environment

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit .env dengan production settings:

```env
APP_NAME=RentalMobil
APP_ENV=production
APP_DEBUG=false
APP_URL=https://rental-mobil.id
APP_TIMEZONE=Asia/Jakarta

LOG_CHANNEL=single
LOG_LEVEL=error

# Database
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=rental_mobil
DB_USERNAME=rental_user
DB_PASSWORD=your_strong_password_here

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@rental-mobil.id
MAIL_FROM_NAME="Rental Mobil"

# Payment Gateway
MIDTRANS_SERVER_KEY=your_production_server_key
MIDTRANS_CLIENT_KEY=your_production_client_key
MIDTRANS_IS_PRODUCTION=true

XENDIT_API_KEY=your_production_api_key
XENDIT_WEBHOOK_TOKEN=your_webhook_token

# Google Maps
GOOGLE_MAPS_API_KEY=your_production_google_maps_key
```

### 4. Database Migration

```bash
cd /var/www/rental-mobil

# Run migrations
php artisan migrate --force

# Seed initial data (roles, permissions, etc)
php artisan db:seed --class=RolePermissionSeeder

# Optional: Seed sample data for testing
# php artisan db:seed
```

### 5. Set Permissions

```bash
cd /var/www/rental-mobil

# Set ownership
sudo chown -R www-data:www-data .

# Set permissions
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache

# Storage symlink
php artisan storage:link
```

### 6. Optimize for Production

```bash
cd /var/www/rental-mobil

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

---

## 🗄️ Database Setup

### 1. Database Backup Strategy

```bash
# Create backup directory
mkdir -p /var/www/backups
sudo chown -R deployer:deployer /var/www/backups

# Backup script
cat > /usr/local/bin/backup-db.sh <<'EOF'
#!/bin/bash

BACKUP_DIR="/var/www/backups"
DATE=$(date +%Y%m%d_%H%M%S)
FILENAME="rental_mobil_$DATE.sql"

# Create backup
pg_dump -U rental_user -h localhost rental_mobil > "$BACKUP_DIR/$FILENAME"

# Compress
gzip "$BACKUP_DIR/$FILENAME"

# Remove backups older than 30 days
find "$BACKUP_DIR" -name "*.sql.gz" -mtime +30 -delete

echo "Backup completed: $FILENAME.gz"
EOF

# Make executable
sudo chmod +x /usr/local/bin/backup-db.sh

# Setup cron job (daily at 2 AM)
crontab -e
# Add: 0 2 * * * /usr/local/bin/backup-db.sh
```

### 2. Database Performance Tuning

```sql
-- Connect to PostgreSQL
psql -U rental_user -d rental_mobil

-- Create indexes untuk frequently queried columns
CREATE INDEX idx_bookings_customer_status ON bookings(customer_id, status);
CREATE INDEX idx_bookings_vehicle_dates ON bookings(vehicle_id, pickup_date, return_date);
CREATE INDEX idx_vehicles_branch_status ON vehicles(branch_id, status);
CREATE INDEX idx_payments_booking_status ON payments(booking_id, status);
CREATE INDEX idx_users_email ON users(email);

-- Enable query optimization
ALTER DATABASE rental_mobil SET shared_preload_libraries = 'pg_stat_statements';

-- Analyze database
ANALYZE;

-- Exit
\q
```

---

## 🌐 Web Server Configuration

### Nginx Configuration

```bash
# Create nginx config
sudo nano /etc/nginx/sites-available/rental-mobil

# Add this configuration:
```

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name rental-mobil.id www.rental-mobil.id;
    
    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name rental-mobil.id www.rental-mobil.id;
    
    # SSL certificates
    ssl_certificate /etc/letsencrypt/live/rental-mobil.id/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/rental-mobil.id/privkey.pem;
    
    # Security headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval';" always;
    
    # Root directory
    root /var/www/rental-mobil/public;
    
    index index.html index.php;
    
    charset utf-8;
    
    # Logging
    access_log /var/log/nginx/rental-mobil-access.log;
    error_log /var/log/nginx/rental-mobil-error.log;
    
    # Performance optimizations
    gzip on;
    gzip_vary on;
    gzip_min_length 1000;
    gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml;
    
    # Static files caching
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    # PHP-FPM configuration
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
        fastcgi_intercept_errors off;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 256 16k;
    }
    
    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }
    
    # Rate limiting
    limit_req_zone $binary_remote_addr zone=api:10m rate=10r/s;
    location /api {
        limit_req zone=api burst=20 nodelay;
    }
}
```

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/rental-mobil /etc/nginx/sites-enabled/

# Test configuration
sudo nginx -t

# Restart nginx
sudo systemctl restart nginx
```

---

## 🔒 SSL/HTTPS Setup

### Let's Encrypt SSL Certificate

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Obtain certificate
sudo certbot certonly --nginx -d rental-mobil.id -d www.rental-mobil.id

# Auto-renewal setup (should be automatic)
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer

# Check renewal
sudo certbot renew --dry-run
```

---

## ⚡ Performance Optimization

### 1. PHP-FPM Optimization

```bash
# Edit PHP-FPM config
sudo nano /etc/php/8.3/fpm/pool.d/www.conf

# Key settings:
# pm = dynamic
# pm.max_children = 50
# pm.start_servers = 10
# pm.min_spare_servers = 5
# pm.max_spare_servers = 20

# Restart PHP-FPM
sudo systemctl restart php8.3-fpm
```

### 2. Database Query Optimization

```bash
# Enable query logging
psql -U rental_user -d rental_mobil <<'EOF'
CREATE EXTENSION IF NOT EXISTS pg_stat_statements;
ALTER SYSTEM SET log_min_duration_statement = 1000; -- log queries > 1s
SELECT pg_reload_conf();
\q
EOF
```

### 3. Caching Strategy

```php
// In .env
CACHE_DRIVER=redis

// Usage in code
$vehicles = cache()->remember('vehicles:all', 3600, function() {
    return Vehicle::active()->get();
});
```

### 4. Queue Configuration

```bash
# Setup Supervisor untuk queue
sudo nano /etc/supervisor/conf.d/rental-mobil.conf

# Add:
```

```ini
[program:rental-mobil-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/rental-mobil/artisan queue:work --sleep=3 --tries=3 --max-jobs=1000
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/supervisor/rental-mobil-queue.log
stopwaitsecs=3600
```

```bash
# Reload supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start rental-mobil-queue:*
```

---

## 📊 Monitoring & Maintenance

### 1. Application Monitoring

```bash
# Setup basic monitoring (install New Relic, Datadog, etc)
# For now, use simple log monitoring

# Monitor error logs
tail -f /var/log/nginx/rental-mobil-error.log
tail -f /var/www/rental-mobil/storage/logs/laravel.log

# Monitor system resources
htop  # CPU & Memory
df -h # Disk space
```

### 2. Automated Health Checks

```bash
# Create monitoring script
cat > /usr/local/bin/health-check.sh <<'EOF'
#!/bin/bash

# Check if website is up
curl -f https://rental-mobil.id/health || echo "Website down!"

# Check disk space
USAGE=$(df / | awk 'NR==2 {print $5}' | sed 's/%//')
if [ $USAGE -gt 80 ]; then
    echo "Disk space critical: $USAGE%"
fi

# Check database
pg_isready -U rental_user -d rental_mobil || echo "Database down!"
EOF

# Make executable & cron
sudo chmod +x /usr/local/bin/health-check.sh
crontab -e
# Add: */5 * * * * /usr/local/bin/health-check.sh
```

### 3. Log Rotation

```bash
# Create logrotate config
sudo nano /etc/logrotate.d/rental-mobil

# Add:
```

```
/var/www/rental-mobil/storage/logs/*.log {
    daily
    compress
    missingok
    rotate 14
    notifempty
    create 0640 www-data www-data
}

/var/log/nginx/rental-mobil*.log {
    daily
    compress
    missingok
    rotate 14
    notifempty
    sharedscripts
    postrotate
        if [ -f /var/run/nginx.pid ]; then \
            kill -USR1 `cat /var/run/nginx.pid`; \
        fi
    endscript
}
```

---

## 💾 Backup & Recovery

### 1. Backup Strategy

```bash
# Daily database backup
0 2 * * * /usr/local/bin/backup-db.sh

# Weekly application backup
0 3 * * 0 tar -czf /var/www/backups/app_$(date +\%Y\%m\%d).tar.gz /var/www/rental-mobil/

# Keep backups for 30 days
find /var/www/backups -name "*.sql.gz" -mtime +30 -delete
find /var/www/backups -name "app_*.tar.gz" -mtime +30 -delete
```

### 2. Restore from Backup

```bash
# Restore database
gunzip < /var/www/backups/rental_mobil_20240101_020000.sql.gz | \
    psql -U rental_user -d rental_mobil

# Restore application
cd /var/www
tar -xzf backups/app_20240101.tar.gz
```

---

## 🔧 Troubleshooting

### Common Issues

#### 1. 502 Bad Gateway

```bash
# Check PHP-FPM status
sudo systemctl status php8.3-fpm

# Check PHP-FPM socket
ls -la /run/php/php8.3-fpm.sock

# Verify FPM config
sudo php-fpm8.3 -t

# Restart FPM
sudo systemctl restart php8.3-fpm
```

#### 2. Database Connection Error

```bash
# Check PostgreSQL
sudo systemctl status postgresql

# Test connection
psql -U rental_user -d rental_mobil -h localhost

# Check Laravel logs
tail -f /var/www/rental-mobil/storage/logs/laravel.log
```

#### 3. High Memory Usage

```bash
# Check PHP-FPM processes
ps aux | grep php-fpm

# Reduce max children in PHP-FPM
sudo nano /etc/php/8.3/fpm/pool.d/www.conf
# Reduce pm.max_children value

# Restart PHP-FPM
sudo systemctl restart php8.3-fpm
```

#### 4. SSL Certificate Issues

```bash
# Verify certificate
sudo certbot certificates

# Force renewal
sudo certbot renew --force-renewal

# Update Nginx config if certificate path changed
sudo nano /etc/nginx/sites-available/rental-mobil

# Test & reload
sudo nginx -t
sudo systemctl reload nginx
```

---

## 📋 Deployment Checklist

Before going live:

- [ ] Server OS updated & secured
- [ ] All required software installed
- [ ] PostgreSQL database created & tested
- [ ] Application cloned & configured
- [ ] Environment variables set correctly
- [ ] Database migrations completed
- [ ] Initial seed data loaded
- [ ] File permissions set correctly
- [ ] Storage symlink created
- [ ] Assets compiled for production
- [ ] Nginx/Apache configured
- [ ] SSL certificate installed
- [ ] Queue supervisor configured
- [ ] Backup script setup
- [ ] Monitoring configured
- [ ] DNS pointed to server
- [ ] Domain accessible via HTTPS
- [ ] Authentication tested
- [ ] Payment gateway tested
- [ ] Email sending tested
- [ ] Database backups automated

---

## 🚀 Post-Deployment Monitoring

### Weekly Tasks

- Check error logs for exceptions
- Monitor database size growth
- Verify backups are working
- Check certificate expiration date

### Monthly Tasks

- Review performance metrics
- Update dependencies
- Test disaster recovery plan
- Audit user access logs

### Quarterly Tasks

- Load testing
- Security audit
- Database optimization
- Capacity planning

---

**Deployment Complete! 🎉**

For issues or questions, contact the development team.
