# YenyaSoft Scoreboard Backend

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About This Project

This is the backend application for the YenyaSoft Scoreboard project, built with Laravel. It provides APIs for managing matches, players, teams, and leagues.

## Prerequisites

Before you begin, ensure you have the following installed:

* PHP >= 8.1
* Composer
* MySQL or any other database supported by Laravel
* Git

## Installation

1. **Clone the repository**

```bash
git clone https://github.com/aryanmalla19/yenyasoft-scoreboard-be.git
cd yenyasoft-scoreboard-be
```

2. **Install dependencies**

```bash
composer install
```

3. **Setup environment file**

```bash
cp .env.example .env
```

4. **Generate application key**

```bash
php artisan key:generate
```

## Environment Variables

Update your `.env` with database, Reverb, Pusher, and Sanctum configurations:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

REVERB_HOST=localhost
REVERB_APP_ID=
REVERB_APP_KEY=
REVERB_APP_SECRET=
REVERB_DEFAULT=pusher
REVERB_PORT=8080
REVERB_SCHEME=http

BROADCAST_DRIVER=pusher
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

SANCTUM_STATEFUL_DOMAINS=http://localhost:5173
SESSION_DOMAIN=localhost
```

## Database Setup

1. Create a new database in MySQL (or your preferred DB).
2. Update `.env` with your database credentials.
3. Run migrations and seeders

```bash
php artisan migrate --seed
```

> After running the seeders, you can log in as an admin using:
>
> * Email: `admin@admin.com`
> * Password: `Password@123`

## Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

By default, the server runs at `http://127.0.0.1:8000`.

## Dependencies & Packages

This project uses the following main packages:

* `laravel/framework` - The core Laravel framework
* `laravel/sanctum` - API authentication and session management for SPA
* `barryvdh/laravel-cors` - Cross-Origin Resource Sharing support
* `reverb/laravel` - Real-time WebSocket broadcasting with Reverb
* Other packages as listed in `composer.json`

## Reverb & Broadcasting

This project uses Reverb for real-time event broadcasting. Ensure Reverb is running with the host, app ID, key, secret, and default driver configured in `.env`. Laravel broadcasting is configured using Pusher driver to handle WebSocket events.

## Sanctum

Sanctum is used for API authentication. Make sure your SPA frontend domain is added to `SANCTUM_STATEFUL_DOMAINS` and `SESSION_DOMAIN` is set correctly in `.env` for proper cookie-based authentication.

## Seeders

Seeders create default data for:

* Admin

Run seeders using:

```bash
php artisan db:seed
```
