# Menu SaaS

Laravel-based SaaS for restaurant menu management, public QR menu pages, owner subscription controls, and printable permanent QR designs.

## Safety First

This project can contain real customer data. Do not reset, wipe, truncate, or rebuild the database to solve development issues.

Forbidden without explicit same-message approval and a fresh backup:

```bash
php artisan migrate:fresh
php artisan migrate:reset
php artisan migrate:refresh
php artisan db:wipe
```

Use additive migrations and idempotent seeders. Seeders that add menu data should use `updateOrCreate`, `firstOrCreate`, or `upsert` and must preserve existing customer records.

## Local Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
```

For development:

```bash
composer run dev
```

## Useful Checks

```bash
php artisan test
npm run build
vendor/bin/pint --dirty
```

## Database Notes

- `categories` and `products` use soft deletes so menu records can be hidden without destroying customer data.
- Permanent QR links use `/r/{code}` and redirect to the current menu slug.
- Keep `ALLOW_DESTRUCTIVE_DB_COMMANDS=false` unless a backup exists and the destructive command was explicitly approved.

## Arabic And RTL

Admin screens and customer-facing menu pages include Arabic text. Keep files UTF-8 encoded and avoid PowerShell piping for Arabic SQL imports or exports.
