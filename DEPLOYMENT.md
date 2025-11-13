# 🚀 DEPLOYMENT & PRODUCTION - Sistem Absensi BPKAD

## 📋 Pre-Deployment Checklist

### Code Quality

-   [ ] Semua feature sudah di-test
-   [ ] Tidak ada TODO atau FIXME di code
-   [ ] Semua console.log dihapus
-   [ ] Code di-review oleh tim
-   [ ] Documentation lengkap
-   [ ] Error handling complete

### Database

-   [ ] Database schema final
-   [ ] Migration scripts tested
-   [ ] Seeder data prepared
-   [ ] Backup strategy planned
-   [ ] Rollback procedure documented

### Security

-   [ ] `.env` file secured
-   [ ] APP_KEY generated
-   [ ] APP_DEBUG = false
-   [ ] CORS configured
-   [ ] HTTPS certificate ready
-   [ ] Database password strong
-   [ ] API keys secured

### Performance

-   [ ] Database queries optimized
-   [ ] Caching configured
-   [ ] Assets minified
-   [ ] Images optimized
-   [ ] Load tested
-   [ ] Response time acceptable

---

## 🔧 Production Setup Steps

### 1. Server Preparation

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install -y php8.2-cli php8.2-fpm php8.2-mysql php8.2-mbstring
sudo apt install -y php8.2-xml php8.2-curl php8.2-zip

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install MySQL
sudo apt install -y mysql-server

# Install Nginx
sudo apt install -y nginx

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

### 2. Project Deployment

```bash
# Clone/upload project
cd /var/www
git clone <repo-url> absensi-bpkad
# atau upload via FTP/SFTP

cd absensi-bpkad

# Install dependencies
composer install --optimize-autoloader --no-dev
npm ci --production

# Setup environment
cp .env.example .env

# Edit .env untuk production
nano .env
```

### 3. Environment Configuration (.env)

```env
APP_NAME="Sistem Absensi BPKAD"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://absensi.bpkad.go.id

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=absensi_bpkad_prod
DB_USERNAME=absensi_user
DB_PASSWORD=STRONG_PASSWORD_HERE

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=YOUR_USERNAME
MAIL_PASSWORD=YOUR_PASSWORD
```

### 4. Database Setup

```bash
# Create database
sudo mysql -u root -p

> CREATE DATABASE absensi_bpkad_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> CREATE USER 'absensi_user'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD_HERE';
> GRANT ALL PRIVILEGES ON absensi_bpkad_prod.* TO 'absensi_user'@'localhost';
> FLUSH PRIVILEGES;
> EXIT;

# Run migrations
php artisan migrate --force

# Seed data
php artisan db:seed --force
```

### 5. Laravel Optimization

```bash
# Generate app key
php artisan key:generate

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize

# Build frontend assets
npm run build
```

### 6. Web Server Configuration (Nginx)

```nginx
# /etc/nginx/sites-available/absensi.bpkad.go.id

server {
    listen 80;
    listen [::]:80;
    server_name absensi.bpkad.go.id;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name absensi.bpkad.go.id;

    # SSL Certificate
    ssl_certificate /etc/letsencrypt/live/absensi.bpkad.go.id/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/absensi.bpkad.go.id/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Root directory
    root /var/www/absensi-bpkad/public;
    index index.php index.html;

    # Logs
    access_log /var/log/nginx/absensi_access.log;
    error_log /var/log/nginx/absensi_error.log;

    # Client upload size
    client_max_body_size 100M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Static files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }

    # Deny access to sensitive files
    location ~ /\. {
        deny all;
    }

    location ~ /^\.well-known/ {
        allow all;
    }
}
```

### 7. File Permissions

```bash
# Set ownership
sudo chown -R www-data:www-data /var/www/absensi-bpkad

# Set permissions
sudo chmod -R 755 /var/www/absensi-bpkad
sudo chmod -R 775 /var/www/absensi-bpkad/storage
sudo chmod -R 775 /var/www/absensi-bpkad/bootstrap/cache

# Set storage permissions
sudo chmod -R 777 /var/www/absensi-bpkad/storage/logs
sudo chmod -R 777 /var/www/absensi-bpkad/storage/framework
```

### 8. SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Generate certificate
sudo certbot certonly --nginx -d absensi.bpkad.go.id

# Auto-renewal
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer
```

### 9. Supervisor Configuration (Queue)

```ini
# /etc/supervisor/conf.d/laravel-worker.conf

[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/absensi-bpkad/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=8
redirect_stderr=true
stdout_logfile=/var/www/absensi-bpkad/storage/logs/worker.log
```

### 10. Cron Job untuk Scheduled Tasks

```bash
# Edit crontab
sudo crontab -e

# Add Laravel scheduler
* * * * * cd /var/www/absensi-bpkad && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🔍 Post-Deployment Verification

```bash
# Check Laravel health
php artisan health

# Check database connection
php artisan db

# Run tests
php artisan test

# Check routes
php artisan route:list

# Check permissions
ls -la /var/www/absensi-bpkad/storage
```

---

## 📊 Monitoring & Maintenance

### Log Monitoring

```bash
# Real-time logs
tail -f /var/www/absensi-bpkad/storage/logs/laravel.log

# Error logs
tail -f /var/log/nginx/absensi_error.log

# Access logs
tail -f /var/log/nginx/absensi_access.log
```

### Database Maintenance

```bash
# Backup database
mysqldump -u absensi_user -p absensi_bpkad_prod > backup_$(date +%Y%m%d).sql

# Schedule automated backups
0 2 * * * mysqldump -u absensi_user -pPASSWORD absensi_bpkad_prod | gzip > /backups/db_$(date +\%Y\%m\%d).sql.gz
```

### Performance Monitoring

```bash
# Monitor disk space
df -h

# Monitor memory
free -h

# Monitor CPU
top

# Monitor MySQL
mysql -u root -p -e "SHOW PROCESSLIST;"
```

---

## 🚨 Troubleshooting

### High Memory Usage

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Optimize
php artisan optimize
```

### Slow Queries

```bash
# Enable query logging in .env
LOG_QUERIES=true

# Analyze logs
php artisan db:show

# Add database indexes
php artisan make:migration add_indexes_to_attendances
```

### 503 Service Unavailable

```bash
# Check PHP-FPM status
sudo systemctl status php8.2-fpm

# Restart services
sudo systemctl restart php8.2-fpm nginx

# Check error log
tail -f /var/log/nginx/error.log
```

---

## 📅 Maintenance Schedule

### Daily

-   [ ] Monitor error logs
-   [ ] Check system resources
-   [ ] Monitor attendance checks

### Weekly

-   [ ] Database backup
-   [ ] Review user activity
-   [ ] Check security logs

### Monthly

-   [ ] Full system backup
-   [ ] Database optimization
-   [ ] Performance review
-   [ ] Security audit

### Quarterly

-   [ ] Update dependencies
-   [ ] Security patches
-   [ ] System audit

---

## 🔒 Security Hardening

### After Deployment

```bash
# Disable directory listing
echo "Options -Indexes" > /var/www/absensi-bpkad/public/.htaccess

# Remove sensitive files
rm -f /var/www/absensi-bpkad/.env.example
rm -rf /var/www/absensi-bpkad/.git

# Set file permissions (readonly)
sudo chown root:root /var/www/absensi-bpkad/.env
sudo chmod 400 /var/www/absensi-bpkad/.env

# Setup firewall
sudo ufw enable
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
```

---

## 📞 Emergency Procedures

### Database Corruption

```bash
# Check database
php artisan db:check

# Repair
mysqlcheck -u root -p --auto-repair absensi_bpkad_prod

# Restore from backup
mysql -u root -p absensi_bpkad_prod < backup.sql
```

### Application Down

```bash
# Check logs
tail -f /var/www/absensi-bpkad/storage/logs/laravel.log

# Restart services
sudo systemctl restart nginx php8.2-fpm mysql

# Clear cache
php artisan cache:clear
php artisan view:clear
```

### Disk Full

```bash
# Find large files
du -sh /var/www/absensi-bpkad/*

# Clear old logs
find /var/www/absensi-bpkad/storage/logs -mtime +30 -delete

# Clear cache
php artisan cache:clear
```

---

## ✅ Go-Live Checklist

-   [ ] All tests passed
-   [ ] Database migrated
-   [ ] SSL certificate installed
-   [ ] Email configured
-   [ ] Backups automated
-   [ ] Monitoring set up
-   [ ] Team trained
-   [ ] Documentation ready
-   [ ] Support process defined
-   [ ] Rollback plan documented

---

## 📞 Support Contact

-   **Technical Support**: tech-support@bpkad.go.id
-   **System Admin**: admin@bpkad.go.id
-   **Emergency**: +62-XXX-XXXX-XXXX

---

**Last Updated**: 11 November 2025
**Version**: 1.0.0
**Status**: Ready for Production
