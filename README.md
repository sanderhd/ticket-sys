# Ticket System

A Laravel-based ticket management system for handling customer support tickets, comments, and contact messages.

## Features

- User authentication and role management
- Ticket creation, assignment, and tracking
- Comment system for ticket discussions
- Contact message handling
- Priority and label management for tickets
- Responsive UI with Tailwind CSS
- RESTful API endpoints

## Requirements

- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL or another supported database

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/sanderhd/ticket-sys.git
   cd ticket-sys
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node.js dependencies:
   ```bash
   npm install
   ```

4. Copy the environment file and configure it:
   ```bash
   cp .env.example .env
   ```
   Update the database settings in `.env`.

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run database migrations:
   ```bash
   php artisan migrate
   ```

7. (Optional) Seed the database:
   ```bash
   php artisan db:seed
   ```

8. Build assets:
   ```bash
   npm run dev
   ```

9. Start the development server:
   ```bash
   php artisan serve
   ```

10. Access the application at `http://localhost:8000`.

## Usage

- Register or log in as a user.
- Create and manage tickets.
- Add comments to tickets.
- View and respond to contact messages.

## Testing

Run the test suite with:
```bash
php artisan test
```

## Contributing

1. Fork the repository.
2. Create a feature branch.
3. Make your changes and commit.
4. Push to your fork and create a pull request.

## License

This project is licensed under the MIT License.
