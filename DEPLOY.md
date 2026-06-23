# Production Deployment Guide: QRHub

This document outlines the steps to deploy **QRHub** to a production server (Ubuntu VPS) using Docker and Docker Compose.

---

## Prerequisites

Ensure your target server has the following installed:
1. **Docker Engine** (v20.10+)
2. **Docker Compose** (v2.0+)
3. A **Domain Name** (e.g. `qrhub.com`) pointed to your server's IP address.

---

## 1. Setup Environment Configurations

Clone the project files into your server directory (e.g., `/var/www/qrhub`).

Create the production `.env` file from the example:
```bash
cp .env.example .env
```

Edit `.env` to configure credentials:
```ini
APP_NAME=QRHub
APP_ENV=production
APP_DEBUG=false
APP_URL=https://qrhub.com  # Replace with your domain

# Ensure session cookies are secure on HTTPS production setups
SESSION_SECURE_COOKIE=true

DB_CONNECTION=mysql
DB_HOST=db                 # Points to the 'db' service name in docker-compose
DB_PORT=3306
DB_DATABASE=qrhub
DB_USERNAME=qrhub_user
DB_PASSWORD=secure_production_password
```

---

## 2. Boot Services using Docker Compose

Run the following command to build the containers and boot them in the background (detached mode):
```bash
docker compose up -d --build
```

The startup script will automatically:
1. Wait for the database container to health-check.
2. Execute all schema migrations.
3. Seed default admin credentials (`admin@qrhub.com` / `admin123`) and default static pages.
4. Optimize app speeds by running `config:cache`, `route:cache`, and `view:cache`.

---

## 3. Generate Application Asset Bundles

If not building inside the container, build frontend styles and scripts on the server:
```bash
npm install
npm run build
```

Alternatively, you can build them locally and push the `public/build` directory to your repository.

---

## 4. Install Let's Encrypt SSL Certificates

On your host machine, install Certbot and get a certificate:
```bash
sudo apt update
sudo apt install certbot python3-certbot-nginx -y
```

Configure Certbot to secure Nginx. Since Certbot will configure a local Nginx proxy on the host, you should configure Nginx on the host to proxy requests to container port `80` (or update `docker-compose.yml` to map container port `80` to a custom host port, e.g., `8080`, and configure host Nginx to proxy pass to `http://127.0.0.1:8080`).

Example host Nginx configuration:
```nginx
server {
    listen 80;
    server_name qrhub.com www.qrhub.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl;
    server_name qrhub.com www.qrhub.com;

    ssl_certificate /etc/letsencrypt/live/qrhub.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/qrhub.com/privkey.pem;

    location / {
        proxy_pass http://127.0.0.1:8080; # Map your compose web port here
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

Obtain certificate:
```bash
sudo certbot --nginx -d qrhub.com -d www.qrhub.com
```

---

## 5. Post-Deployment Verification

1. Check container statuses:
   ```bash
   docker compose ps
   ```
2. Check application logs if you encounter any issues:
   ```bash
   docker compose logs -f app
   ```
3. Visit `https://yourdomain.com/admin/login` and log in with default credentials:
   - **Email:** `admin@qrhub.com`
   - **Password:** `admin123`
   - **Important:** Modify your email and password immediately in the database or admin control panel settings for system security!
