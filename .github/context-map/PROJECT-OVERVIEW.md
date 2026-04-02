# Project Overview

## Project Name
**Bonanza Insumos**

## Project Type
Laravel 13 Web Application

## Current Status
🟢 **Fresh starter project** - Minimal customization, ready for feature development

## Purpose
Bonanza Insumos is a Laravel-based web application built on a modern, clean foundation. It's configured with:
- User authentication system
- Professional frontend tooling (Vite + Tailwind + Alpine.js)
- Database migrations and seeders
- Test infrastructure

## Technology Stack

### Backend
- **PHP**: 8.4+
- **Framework**: Laravel 13
- **Database**: SQLite (default, configurable)
- **Database ORM**: Eloquent

### Frontend
- **Build Tool**: Vite 8
- **CSS Framework**: Tailwind CSS 4
- **JavaScript Library**: Alpine.js 3.15
- **HTTP Client**: Axios (pre-configured with CSRF headers)

### Development & Testing
- **Testing**: PHPUnit 12.5
- **Code Quality**: Laravel Pint (PSR-12)
- **Error Handling**: Collision (enhanced exceptions)
- **Logging**: Laravel Pail

## Key Features (Current)
- ✅ User authentication (Laravel Breeze ready)
- ✅ Welcome landing page
- ✅ Database seeding with test user
- ✅ Vite hot module reloading (HMR) for development
- ✅ Tailwind CSS production optimization
- ✅ PSR-12 code formatting tools

## Project Structure
```
├── app/                 # Application code
│   ├── Http/           # Controllers
│   ├── Models/         # Eloquent models
│   └── Providers/      # Service providers
├── resources/          # Frontend assets
│   ├── css/            # Tailwind stylesheets
│   ├── js/             # Alpine.js components
│   └── views/          # Blade templates
├── routes/             # Route definitions
├── database/           # Migrations & seeders
│   ├── factories/      # Eloquent factories
│   ├── migrations/     # Database schema
│   └── seeders/        # Test data
└── tests/              # PHPUnit tests
```

## Development Environment

- **Node Version**: 18+ (for npm/Vite)
- **PHP Version**: 8.4+
- **Composer**: Latest
- **OS**: Windows (primary), but Unix-compatible

## Default User Account
```
Email:    test@example.com
Password: password
```

## Future Development Areas
- Additional models and controllers
- API endpoints
- Authentication refinement
- Feature-specific modules
- Client-specific customizations

---
For detailed architecture information, see [ARCHITECTURE.md](ARCHITECTURE.md)
