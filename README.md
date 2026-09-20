# Viralume Medical Appointment System

A modern Laravel + Vue.js application for managing medical appointments, built with Laravel Fortify for authentication and Inertia.js for seamless frontend-backend integration.

## Features

### Authentication & Security
- User registration, login, and password reset (via Laravel Fortify)
- Email verification
- Two-factor authentication (2FA)
- Passkey/WebAuthn support (via Laravel Passkeys)
- Role-based access control (Spatie Laravel Permission)
- Secure session management

### Core Functionality
- **Patient Management**: Patient profiles linked to user accounts
- **Doctor Management**: Doctor profiles with specialization, bio, pricing, and availability
- **Appointment Scheduling**: Book, confirm, cancel, and complete appointments
- **Doctor Schedules**: Weekly availability schedules for doctors
- **Time Off Management**: Track doctor absences and unavailability

### User Roles
- **Admin**: Full system access
- **Doctor**: Manage own schedule, view appointments
- **Patient**: Book and manage appointments
- **Receptionist**: Manage appointments and patient/doctor records

### Technology Stack
- **Backend**: Laravel 13.x (PHP 8.4)
- **Frontend**: Vue 3 + Inertia.js 3
- **Styling**: Tailwind CSS 4
- **Build Tool**: Vite
- **Database**: MySQL
- **Authentication**: Laravel Fortify, Laravel Passkeys
- **Authorization**: Spatie Laravel Permission
- **Development Tools**: Pest PHP, Laravel Sail, Laravel Pint

## Installation

1. Clone the repository
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install Node.js dependencies:
   ```bash
   npm install
   ```
4. Copy the environment file:
   ```bash
   cp .env.example .env
   ```
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Configure your database in `.env` and run migrations:
   ```bash
   php artisan migrate
   ```
7. Start the development server:
   ```bash
   npm run dev
   ```
   In another terminal:
   ```bash
   php artisan serve
   ```

## Usage

- Visit `http://localhost:8000` to access the application
- Register a new account or log in with existing credentials
- Verify your email address to access the dashboard
- Use the sidebar navigation to access different modules (when implemented)

## API Documentation

The application uses Inertia.js for client-side routing, eliminating the need for a separate API. However, the backend follows RESTful conventions for potential future API extraction.

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing-feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License.

## Acknowledgments

- Laravel Team
- Inertia.js Team
- Vue.js Team
- Tailwind CSS Team
- Spatie Laravel Permission