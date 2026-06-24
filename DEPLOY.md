# QRHub — Production Deployment Guide

> **Laravel 13 · PHP 8.3 · Vite 8 · TailwindCSS v4 · Alpine.js**

---

## Table of Contents

1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Render.com (Docker)](#rendercom-docker)
3. [Railway (Docker)](#railway-docker)
4. [VPS / DigitalOcean / Hetzner](#vps--digitalocean--hetzner)
5. [Hostinger (Shared / Cloud)](#hostinger-shared--cloud)
6. [InfinityFree / cPanel Shared Hosting](#infinityfree--cpanel-shared-hosting)
7. [Environment Variables Reference](#environment-variables-reference)
8. [Post-Deployment Steps](#post-deployment-steps)
9. [Troubleshooting](#troubleshooting)

---

## Pre-Deployment Checklist

Before deploying to any platform, confirm the following:

- [ ] `.env` is **not** committed to git (it's in `.gitignore`)
- [ ] `vendor/` is **not** committed to git (it's in `.gitignore`)
- [ ] `node_modules/` is **not** committed to git (it's in `.gitignore`)
- [ ] `APP_DEBUG=false` in production environment
- [ ] `APP_ENV=production` in production environment
- [ ] `APP_KEY` is set (generate with `php artisan key:generate --show`)
- [ ] Database connection details are correct
- [ ] `ADMIN_EMAIL` and `ADMIN_PASSWORD` are set before first deploy
- [ ] `FIRST_SETUP=true` on **first deploy only** (then set to `false`)

---

## Render.com (Docker)

Render supports the included `Dockerfile` and `render.yaml` natively.

### Steps

1. **Push code to GitHub/GitLab**
   ```bash
   git add .
   git commit -m "Production deployment"
   git push origin main
   ```

2. **Create a new Render Web Service**
   - Go to [render.com](https://render.com) → New → Blueprint
   - Connect your repository — Render auto-detects `render.yaml`
   - Or: New → Web Service → Docker → connect repo

3. **Set Environment Variables** (in Render dashboard → Environment):
   ```
   APP_KEY=base64:...   ← generate with: php artisan key:generate --show
   APP_URL=https://your-app.onrender.com
   ADMIN_EMAIL=admin@yourdomain.com
   ADMIN_PASSWORD=SecurePassword123!
   FIRST_SETUP=true    ← set true for first deploy, false after
   ```

4. **Database**: Create a Render MySQL database (or use PlanetScale/ClearDB)
   - Render auto-injects `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` if using `render.yaml`

5. **Deploy** — Click "Create Web Service" and wait for build.

6. **After First Deploy**: Set `FIRST_SETUP=false` → trigger a redeploy.

### Health Check
Render pings `GET /health` → should return HTTP 200.

---

## Railway (Docker)

1. **Install Railway CLI** (optional):
   ```bash
   npm install -g @railway/cli
   railway login
   ```

2. **Deploy via GitHub**:
   - Go to [railway.app](https://railway.app) → New Project → Deploy from GitHub
   - Railway detects `railway.json` automatically

3. **Add MySQL plugin** in Railway dashboard (click `+ New` → Database → MySQL)

4. **Set Environment Variables** in Railway Variables panel:
   ```
   APP_KEY=base64:...
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://${{RAILWAY_STATIC_URL}}
   DB_HOST=${{MYSQLHOST}}
   DB_PORT=${{MYSQLPORT}}
   DB_DATABASE=${{MYSQLDATABASE}}
   DB_USERNAME=${{MYSQLUSER}}
   DB_PASSWORD=${{MYSQLPASSWORD}}
   SESSION_DRIVER=database
   CACHE_STORE=database
   QUEUE_CONNECTION=database
   FIRST_SETUP=true
   ADMIN_EMAIL=admin@yourdomain.com
   ADMIN_PASSWORD=SecurePassword123!
   ```

5. After first deploy → set `FIRST_SETUP=false` and redeploy.

---

## VPS / DigitalOcean / Hetzner

### Using Docker Compose

```bash
# 1. SSH into your VPS
ssh user@your-vps-ip

# 2. Clone the repository
git clone https://github.com/your/qrhub.git /var/www/qrhub
cd /var/www/qrhub

# 3. Create and configure .env
cp .env.example .env
nano .env
# Set: APP_KEY, APP_URL, DB_*, ADMIN_*, FIRST_SETUP=true

# 4. Generate APP_KEY
docker run --rm php:8.3-cli php -r "echo 'base64:'.base64_encode(random_bytes(32)).PHP_EOL;"

# 5. Build and start containers
docker-compose up -d --build

# 6. After first deploy — disable seeding
# Edit .env: FIRST_SETUP=false
# docker-compose restart app
```

### Using Nginx + PHP-FPM directly (no Docker)

```bash
# 1. Install dependencies
sudo apt install -y php8.3-fpm php8.3-mysql php8.3-gd php8.3-imagick \
     php8.3-mbstring php8.3-zip php8.3-opcache php8.3-intl \
     nginx mysql-server nodejs npm

# 2. Clone project
git clone https://github.com/your/qrhub.git /var/www/qrhub

# 3. Install PHP dependencies
cd /var/www/qrhub
composer install --no-dev --optimize-autoloader

# 4. Install and build assets
npm ci && npm run build

# 5. Configure environment
cp .env.example .env
php artisan key:generate
# Edit .env with your settings

# 6. Set permissions
sudo chown -R www-data:www-data /var/www/qrhub
sudo chmod -R 755 /var/www/qrhub/storage
sudo chmod -R 755 /var/www/qrhub/bootstrap/cache

# 7. Run migrations & seed (first time only)
php artisan migrate --force
php artisan db:seed --force

# 8. Create storage symlink
php artisan storage:link

# 9. Optimise for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 10. Configure Nginx (point root to /var/www/qrhub/public)
# Copy .docker/nginx/default.conf as a reference
```

---

## Hostinger (Shared / Cloud)

Hostinger supports PHP 8.3 with MySQL. This project works on Hostinger's Business / Cloud plans.

### Steps

1. **Upload files** via hPanel File Manager or FTP:
   - Upload ALL files **except** `vendor/`, `node_modules/`, `.env`
   - Upload the pre-built `public/build/` directory
   - Set the document root to `public/`

2. **On your local machine** — build assets and prepare:
   ```bash
   npm run build
   composer install --no-dev --optimize-autoloader
   ```

3. **Upload `vendor/`** via FTP (Hostinger doesn't support Composer via terminal on shared plans)

4. **Create `.env`** via hPanel or FTP with production values

5. **Create MySQL database** in hPanel → Databases

6. **Run migrations** via Hostinger SSH (if available) or via a temporary PHP script:
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

7. The `public/php.ini` file is already included for PHP configuration overrides.

---

## InfinityFree / cPanel Shared Hosting

> ⚠️ InfinityFree has significant limitations (no SSH, limited PHP). This is for static-ish usage only.

1. Build locally:
   ```bash
   npm run build
   composer install --no-dev --optimize-autoloader
   ```

2. Upload everything to the server via FTP.

3. Create MySQL database via cPanel → MySQL Databases.

4. Upload `vendor/` directory via FTP.

5. Create `.env` with your database credentials.

6. Import database via cPanel → phpMyAdmin (run migrations manually or export SQL).

7. The `public/php.ini` provides PHP configuration.

8. Point document root to the `public/` folder.

---

## Environment Variables Reference

| Variable | Description | Required |
|----------|-------------|----------|
| `APP_NAME` | Application name | ✅ |
| `APP_ENV` | Must be `production` | ✅ |
| `APP_KEY` | 32-byte encryption key (generate with artisan) | ✅ |
| `APP_DEBUG` | Must be `false` in production | ✅ |
| `APP_URL` | Full URL with https:// | ✅ |
| `DB_CONNECTION` | `mysql` | ✅ |
| `DB_HOST` | Database host | ✅ |
| `DB_PORT` | Database port (default: 3306) | ✅ |
| `DB_DATABASE` | Database name | ✅ |
| `DB_USERNAME` | Database user | ✅ |
| `DB_PASSWORD` | Database password | ✅ |
| `SESSION_DRIVER` | `database` (recommended) | ✅ |
| `CACHE_STORE` | `database` (recommended) | ✅ |
| `QUEUE_CONNECTION` | `database` or `sync` | ✅ |
| `SESSION_SECURE_COOKIE` | `true` (HTTPS) | ✅ |
| `ADMIN_EMAIL` | Admin login email | First deploy |
| `ADMIN_PASSWORD` | Admin login password | First deploy |
| `FIRST_SETUP` | `true` = run seeders on startup | First deploy only |
| `LOG_LEVEL` | `error` in production | Recommended |
| `MAIL_MAILER` | `smtp` or `log` | Optional |

---

## Post-Deployment Steps

1. **Verify health check**: `curl https://your-domain.com/health`
   ```json
   {"status":"ok","service":"QRHub","env":"production","time":"..."}
   ```

2. **Login to admin**: `https://your-domain.com/admin/login`
   - Use the `ADMIN_EMAIL` and `ADMIN_PASSWORD` you set

3. **Change admin password** immediately after first login via the database or by updating the seeder env variables and re-running with `FIRST_SETUP=true`

4. **Set `FIRST_SETUP=false`** in your environment to prevent re-seeding on restart

5. **Configure storage symlink** if images aren't loading:
   ```bash
   php artisan storage:link
   ```

6. **Set up a queue worker** if using async jobs:
   ```bash
   php artisan queue:work --daemon
   ```

---

## Troubleshooting

### 500 Error on Production
```bash
php artisan config:clear
php artisan cache:clear
# Check storage/logs/laravel.log
```

### Storage Permission Error
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Vite Asset 404 (Missing CSS/JS)
```bash
npm run build
# Ensure public/build/ directory is deployed
```

### DB Connection Refused
- Verify `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD` in `.env`
- Ensure MySQL user has permissions: `GRANT ALL ON qrhub.* TO 'user'@'%';`

### QR PNG Download Not Working
- PNG download requires `imagick` PHP extension
- If unavailable, SVG download still works
- Install: `apt install php8.3-imagick` on VPS

### Session Not Working
- Ensure `SESSION_DRIVER=database` and `sessions` table exists (run migrations)
- Set `SESSION_SECURE_COOKIE=true` if on HTTPS

---

*Generated by QRHub Deployment Audit — $(date)*
