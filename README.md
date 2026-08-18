# Park Clinic — Backend API

This is the Laravel backend API for the Park Clinic website. It provides RESTful endpoints for the React frontend and the admin dashboard.

## Requirements

- **PHP** ^8.3
- **Composer** (latest)
- **MariaDB** 10+ (or MySQL 8+)
- **Node.js** 20+ (for Vite/frontend asset building)
- **Redis** (optional — for queue driver)

## Stack

| Component | Version |
|-----------|---------|
| Laravel | ^13.8 |
| PHP | ^8.3 |
| Database | MariaDB |
| Auth | JWT (`php-open-source-saver/jwt-auth`) + Sanctum |
| Mail | Queue-based (database driver) |
| Testing | Pest PHP ^4 |
| Formatting | Laravel Pint ^1 |

## Quick Start

```bash
# Clone the repo, then from the project root:

# Copy environment file and customize it
cp .env.example .env

# Install PHP dependencies
composer install

# Generate app key
php artisan key:generate

# Create the database and run migrations
php artisan migrate

# Install & build frontend assets
npm install && npm run build

# Start the development server
composer run dev
```

Or use the setup shortcut (does it all at once):

```bash
composer run setup
```

## Environment Variables

Key environment variables (configured in `.env`):

| Variable | Default | Description |
|----------|---------|-------------|
| `DB_DATABASE` | `backend_api` | Database name |
| `DB_USERNAME` | `root` | Database user |
| `DB_PASSWORD` | | Database password |
| `QUEUE_CONNECTION` | `database` | Queue driver (`database`, `redis`, `sync`) |
| `MAIL_MAILER` | `log` | Mail driver (`smtp`, `log`, `ses`, etc.) |
| `MAIL_QUEUE` | `true` | Queue mail sending (set `false` for instant send) |
| `MAIL_FROM_ADDRESS` | `hello@example.com` | Sender email address |
| `CONTACT_RECEIVER_EMAIL` | (falls back to `MAIL_FROM_ADDRESS`) | Where contact form emails go |
| `JWT_TTL` | `60` | JWT token TTL in minutes |

See `.env.example` for the full list.

## Development Commands

Run all commands from the `backend-api/` directory.

```bash
# Start dev server + queue worker + Vite (all at once)
composer run dev

# Run Pest tests
composer run test

# Full setup (composer install, .env, key gen, migrate, npm build)
composer run setup

# Individual Artisan commands
php artisan serve              # Start Laravel dev server
php artisan migrate            # Run database migrations
php artisan queue:listen       # Process queued jobs (mail, etc.)
php artisan test --compact     # Run tests
vendor/bin/pint --dirty        # Format modified PHP files
```

## API Routes

All routes are prefixed with `/api`.

### Public Routes

| Method | URI | Description |
|--------|-----|-------------|
| POST | `/api/contact` | Submit a contact form message |
| POST | `/api/career/apply` | Submit a career application |
| GET | `/api/career/jobs` | List published job posts |
| GET | `/api/doctors` | List active doctors |
| GET | `/api/doctors/{id}` | Get doctor details |
| GET | `/api/doctors/{id}/image` | Get doctor photo |

### Auth Routes

| Method | URI | Middleware | Description |
|--------|-----|------------|-------------|
| POST | `/api/auth/login` | — | Login and get JWT |
| POST | `/api/auth/logout` | `jwt.cookies` | Logout and invalidate token |
| POST | `/api/auth/refresh` | `jwt.cookies` | Refresh JWT |
| GET | `/api/auth/profile` | `jwt.cookies` | Get authenticated user |

### Admin Routes (all require `jwt.cookies` middleware)

**Contact Messages**

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/api/admin/contacts` | List contacts (paginated, filterable) |
| GET | `/api/admin/contacts/{id}` | Get contact details |
| PATCH | `/api/admin/contacts/{id}/read` | Mark as read |
| PATCH | `/api/admin/contacts/{id}/unread` | Mark as unread |
| PATCH | `/api/admin/contacts/{id}/important` | Toggle important flag |
| POST | `/api/admin/contacts/{id}/reply` | Send a reply email |
| DELETE | `/api/admin/contacts/{id}` | Delete a contact message |

**Doctors**

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/api/admin/doctors` | List all doctors |
| POST | `/api/admin/doctors` | Create a doctor |
| GET | `/api/admin/doctors/{id}` | Get doctor details |
| PUT | `/api/admin/doctors/{id}` | Update a doctor |
| DELETE | `/api/admin/doctors/{id}` | Delete a doctor |

**Job Posts**

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/api/admin/job-posts` | List job posts |
| POST | `/api/admin/job-posts` | Create a job post |
| GET | `/api/admin/job-posts/{id}` | Get job post details |
| PUT | `/api/admin/job-posts/{id}` | Update a job post |
| DELETE | `/api/admin/job-posts/{id}` | Delete a job post |

**Career Applications**

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/api/admin/career-applications` | List career applications |
| GET | `/api/admin/career-applications/{id}` | Get application details |
| DELETE | `/api/admin/career-applications/{id}` | Delete an application |

### Contact Messages — Pagination & Filtering

```
GET /api/admin/contacts?page=1&per_page=10&status=read|unread&search=query
```

Response format:

```json
{
  "data": [...],
  "meta": {
    "total": 100,
    "current_page": 1,
    "last_page": 10,
    "per_page": 10
  }
}
```

## Mail

Mail is sent via the queue by default (`QUEUE_CONNECTION=database`).  
To process queued mail, run:

```bash
php artisan queue:listen
```

To send mail synchronously (useful for shared hosting), set `MAIL_QUEUE=false` in your `.env`.

### Mailables

| Mailable | Purpose |
|----------|---------|
| `ContactAcknowledgementMail` | Auto-reply to contact form submitter |
| `ContactMessageMail` | Notifies the clinic about a new contact message |
| `ContactReplyMail` | Sent when admin replies to a contact message |
| `CareerApplicationAcknowledgementMail` | Auto-reply to career applicant |
| `CareerApplicationMail` | Notifies the clinic about a new application |

## Authentication

Authentication uses **JWT** via `php-open-source-saver/jwt-auth`.  
Tokens are stored in HTTP-only cookies (`jwt.cookies` middleware) for admin routes.

The frontend can also use localStorage-based JWT auth (configured via `VITE_AUTH_STORAGE_TYPE`).

## Testing

```bash
# Run all tests
php artisan test --compact

# Run with filter
php artisan test --compact --filter=ContactTest
```

This project uses **Pest PHP** for testing. Tests live in `tests/Feature/` and `tests/Unit/`.

## Formatting

Run Laravel Pint to format modified PHP files:

```bash
vendor/bin/pint --dirty --format agent
```

## Project Structure

```
backend-api/
├── app/
│   ├── Http/Controllers/Api/    — Public API controllers
│   ├── Http/Controllers/Api/Admin/ — Admin API controllers
│   ├── Mail/                     — Mailable classes
│   ├── Models/                   — Eloquent models
│   ├── Services/                 — Business logic
│   ├── Traits/                   — Reusable traits
│   └── Helpers/                  — Helper classes
├── config/                       — Configuration files
├── database/
│   ├── migrations/               — Schema migrations
│   └── seeders/                  — Database seeders
├── routes/
│   └── api.php                   — All API route definitions
└── tests/                        — Pest tests
```
