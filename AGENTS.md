# AGENTS.md — Project Safety & Development Rules

> This file contains mandatory rules for any AI agent, developer, or automation tool working on this project.
> Follow these instructions exactly. When in doubt, choose the safest option and ask before doing anything destructive.

---

## 1. Golden Rule

This project may contain real user-created data.

Never assume the database is disposable.

Do not reset, wipe, refresh, truncate, or rebuild the database unless the user explicitly asks for that exact destructive action in the same message and a backup has been created first.

---

## 2. Forbidden Database Commands

The following commands are strictly forbidden unless the user gives explicit approval in the same message:

```bash
php artisan migrate:fresh
php artisan migrate:reset
php artisan migrate:refresh
php artisan db:wipe
php artisan schema:dump --prune
```

The following SQL operations are also forbidden unless explicitly approved:

```sql
DROP DATABASE
DROP TABLE
TRUNCATE TABLE
DELETE FROM users
DELETE FROM customers
DELETE FROM restaurants
DELETE FROM products
DELETE FROM orders
DELETE FROM categories
DELETE FROM settings
```

Do not run destructive commands "just to make seeders work".

Do not use database reset commands as a shortcut.

Do not remove existing user-created data.

---

## 3. Mandatory Backup Before Risky Work

Before any risky database operation, create a backup first.

For MySQL, use a safe UTF-8 compatible backup command:

```bash
mysqldump --default-character-set=utf8mb4 -u root database_name > backup_before_changes.sql
```

When importing Arabic or UTF-8 SQL files, do not use PowerShell piping like:

```powershell
Get-Content backup.sql | mysql
```

This can corrupt Arabic text.

Use a direct import instead:

```bash
mysql --default-character-set=utf8mb4 -u root database_name < backup.sql
```

If the database name, environment, or backup path is unclear, stop and ask.

---

## 4. Safe Data Changes Only

When adding or updating demo data, products, categories, restaurants, salons, users, settings, or any business records:

Use additive and idempotent logic only.

Allowed methods:

```php
firstOrCreate()
updateOrCreate()
upsert()
```

Preferred examples:

```php
Category::updateOrCreate(
    ['slug' => 'example-category'],
    [
        'name' => 'Example Category',
        'is_active' => true,
    ]
);
```

```php
Product::updateOrCreate(
    [
        'slug' => 'example-product',
        'restaurant_id' => $restaurant->id,
    ],
    [
        'name' => 'Example Product',
        'price' => 150,
        'category_id' => $category->id,
        'is_active' => true,
    ]
);
```

Avoid unsafe blind creation if duplicates may happen:

```php
Product::create([...]);
```

Never delete existing records unless the user clearly requests deletion.

---

## 5. Seeder Rules

Seeders must be safe, additive, and repeatable.

A seeder is allowed to:

- Add missing records.
- Update records that match a stable unique key.
- Create categories/products/settings only if missing.
- Use `updateOrCreate`, `firstOrCreate`, or `upsert`.

A seeder must not:

- Wipe tables.
- Truncate tables.
- Delete existing records.
- Assume it owns the entire database.
- Run `migrate:fresh`.
- Run `db:wipe`.
- Replace the whole dataset.

When asked to add new products or categories, run only the specific seeder:

```bash
php artisan db:seed --class=SpecificSeederName
```

Do not run:

```bash
php artisan migrate:fresh --seed
```

---

## 6. Migration Rules

Migrations must be normal forward migrations only.

Allowed:

```bash
php artisan migrate
```

Forbidden unless explicitly approved:

```bash
php artisan migrate:fresh
php artisan migrate:reset
php artisan migrate:refresh
```

When adding columns or tables:

- Preserve existing data.
- Use nullable columns when needed.
- Add defaults carefully.
- Avoid changing column types without checking existing data.
- Avoid dropping columns unless explicitly requested.
- Avoid renaming tables/columns unless necessary and approved.

Before writing a migration that could affect existing data, explain the risk.

---

## 7. Environment Safety

Before database work, identify the environment.

Check:

```bash
php artisan env
```

or inspect `.env` carefully.

Production-like environments must be treated as real data environments.

If `APP_ENV=production`, `APP_DEBUG=false`, or the database contains real users/orders/customers/restaurants/products, use maximum caution.

Never run destructive operations on production or real data.

---

## 8. Laravel Project Rules

Follow Laravel best practices.

Prefer:

- Form Requests for validation.
- Policies or Gates for authorization.
- Services for business logic.
- Migrations for schema changes.
- Seeders for additive reference/demo data.
- Transactions for multi-step database writes.
- Soft deletes for important business records where appropriate.

Avoid:

- Duplicating dashboards/layouts.
- Hardcoding business logic in Blade views.
- Writing large unrelated refactors.
- Editing unrelated files.
- Breaking existing admin layout integration.
- Removing existing routes, views, or permissions without reason.

---

## 9. Arabic & RTL Rules

This project uses Arabic RTL admin screens.

When editing UI:

- Keep Arabic text readable and natural.
- Preserve RTL layout.
- Avoid broken Arabic encoding.
- Use UTF-8.
- Do not corrupt Arabic text during SQL import/export.
- Do not use PowerShell piping for Arabic SQL files.

Preferred database charset/collation:

```sql
utf8mb4
utf8mb4_unicode_ci
```

---

## 10. Git Safety

Before risky changes, check status:

```bash
git status
```

Do not discard user changes unless explicitly asked.

Forbidden unless explicitly approved:

```bash
git reset --hard
git clean -fd
git checkout -- .
git push --force
```

If multiple files are modified, summarize exactly what changed.

---

## 11. Agent Workflow

For every task:

1. Read only the files needed for the task.
2. Understand the current implementation before changing it.
3. Make the smallest safe change that solves the problem.
4. Preserve existing data and behavior.
5. Avoid destructive commands.
6. Run relevant checks when possible.
7. Report changed files and commands to run.

Do not scan the whole repository unless necessary.

Do not perform broad rewrites when a targeted fix is enough.

---

## 12. Required Response Format After Changes

After making code changes, respond with:

```md
## Files changed

- path/to/file.php
- path/to/view.blade.php

## What changed

- Clear explanation of the actual change.
- Mention any database impact.
- Mention whether the change is additive or destructive.

## Commands to run

```bash
php artisan migrate
php artisan db:seed --class=SpecificSeederName
php artisan optimize:clear
```

## Safety notes

- No destructive database commands were run.
- Existing records were preserved.
- Backup was created if needed.
```

---

## 13. Emergency Stop Conditions

Stop immediately and ask the user before continuing if:

- A command will wipe or rebuild the database.
- A migration will drop or rename existing columns/tables.
- A script will delete existing users/customers/restaurants/products/orders.
- The environment appears to be production.
- The database contains real business data.
- There is no recent backup before risky work.
- The requested action conflicts with this file.

---

## 14. Database Guard Recommendation

The project should include a guard that blocks dangerous Artisan commands unless explicitly enabled.

Recommended `.env` value:

```env
ALLOW_DESTRUCTIVE_DB_COMMANDS=false
```

Recommended Laravel guard:

```php
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\Event;

public function boot(): void
{
    Event::listen(CommandStarting::class, function (CommandStarting $event) {
        $dangerousCommands = [
            'migrate:fresh',
            'migrate:reset',
            'migrate:refresh',
            'db:wipe',
        ];

        if (! in_array($event->command, $dangerousCommands, true)) {
            return;
        }

        if (! filter_var(env('ALLOW_DESTRUCTIVE_DB_COMMANDS', false), FILTER_VALIDATE_BOOLEAN)) {
            throw new RuntimeException(
                "Blocked dangerous database command: {$event->command}. " .
                "Set ALLOW_DESTRUCTIVE_DB_COMMANDS=true only after backup and explicit approval."
            );
        }
    });
}
```

---

## 15. Final Rule

When the task is to add data, the correct approach is:

```text
Add or update only the requested records.
Preserve everything else.
Never reset the database.
Never run migrate:fresh.
Never run db:wipe.
Never corrupt Arabic text.
Backup before risky work.
```

This rule overrides any shortcut or default development habit.
