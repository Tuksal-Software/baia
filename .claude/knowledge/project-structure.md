# BAIA E-Commerce Platform - Project Structure

## Overview
- **Project Name**: BAIA
- **Type**: E-Commerce Platform (Multi-product)
- **Framework**: Laravel 12.0
- **PHP Version**: ^8.2
- **Frontend**: Blade + Tailwind CSS v4 + Vite 7.0.7
- **Database**: SQLite (default, configurable)

## Directory Structure

```
baia/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # 11 admin controllers
│   │   │   ├── Auth/           # 2 auth controllers
│   │   │   └── [Public]        # 7 public controllers
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   ├── Models/                 # 18 Eloquent models
│   └── Providers/              # 2 service providers
├── config/                     # 11 config files
├── database/
│   ├── factories/              # 1 factory (User)
│   ├── migrations/             # 24 migrations
│   └── seeders/                # 8 seeders
├── public/
├── resources/
│   ├── css/app.css
│   ├── js/
│   └── views/                  # 73+ Blade templates
│       ├── admin/              # Admin panel views
│       ├── auth/               # Login/Register
│       ├── cart/               # Shopping cart
│       ├── categories/         # Category pages
│       ├── checkout/           # Checkout flow
│       ├── components/         # 8 Blade components
│       ├── layouts/            # App & Admin layouts
│       ├── pages/              # Static pages
│       ├── products/           # Product pages
│       └── users/              # User pages
├── routes/
│   ├── web.php                 # 171 lines, 100+ routes
│   └── console.php
├── storage/
├── tests/
│   ├── Feature/
│   └── Unit/
├── .claude/                    # Multi-agent system
│   ├── knowledge/              # Project knowledge base
│   ├── coding-standards/       # Laravel coding standards
│   └── templates/              # Task templates
├── composer.json
├── package.json
├── vite.config.js
└── CLAUDE.md                   # Agent workflow instructions
```

## Key Technologies

| Category | Technology | Version |
|----------|------------|---------|
| Backend | Laravel | 12.0 |
| API Auth | Sanctum | 4.3 |
| Frontend | Tailwind CSS | 4.0.0 |
| Build | Vite | 7.0.7 |
| HTTP Client | Axios | 1.11.0 |
| Testing | PHPUnit | 11.5.3 |
| Code Style | Laravel Pint | 1.24 |

## Development Commands

```bash
composer setup    # Complete project setup
composer dev      # Start dev server (Vite + queue + logs)
composer test     # Run PHPUnit tests
php artisan serve # Start Laravel server
npm run dev       # Start Vite dev server
```

## Authentication

- User model with `is_admin` flag
- AdminMiddleware for admin routes
- Turkish route names (/giris, /kayit, /cikis)

## Features

1. **Product Catalog**: Products with variants, specs, features, images
2. **Categories**: Hierarchical category system with parent/child
3. **Shopping Cart**: Session/user-based cart with discount codes
4. **Orders**: Complete order flow with status tracking
5. **Reviews**: Product reviews with approval system
6. **Admin Panel**: Full CRUD for all entities
7. **CMS**: Sliders, banners, home sections, menus
8. **Newsletter**: Subscriber management
