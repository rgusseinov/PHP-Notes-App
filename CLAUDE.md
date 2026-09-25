# CLAUDE.md

## Project

PHP Notes App — a simple single-page notes application for learning purposes. Notes have: `id`, `title`,
`content`, `created_at`, `updated_at`. Features: create, list, edit, delete.

## Stack

- PHP 8.4, no frameworks, no Composer dependencies for now
  - Apache serves the app with PHP 8.4.25
  - The default `php` CLI on this machine is 7.4 and must not be used for this project — always use `php8.4`
- MySQL 8.4 via PDO
- Plain HTML/CSS, minimal vanilla JS only if needed

## Structure

- `index.php` — single entry point
- `src/` — PHP classes
- `database/` — SQL schema
- `assets/` — public CSS/JS/images
- `config.php` — DB credentials, git-ignored, never read/printed/committed
- `config.example.php` — committed template for `config.php`

## Code rules

- Every PHP file starts with `declare(strict_types=1);`
- Follow PSR-12 style
- Use PDO prepared statements only — never interpolate variables into SQL strings
- Escape all output with `htmlspecialchars`
- Every form that changes data (create/edit/delete) must include and verify a CSRF token

## Database

- Database: `notes_app`, charset `utf8mb4`, collation `utf8mb4_unicode_ci`
- Schema lives in `database/schema.sql`
- Apply schema: `mysql -u <user> -p notes_app < database/schema.sql` (ask me to run it, do not run it yourself)

## Commands

- App is served by Apache from `/var/www/html` at `http://localhost/` — do not start a dev server
- Syntax check a file: `php8.4 -l <file>`

## Working rules

- Never read, print, or commit `config.php`
- Ask before changing the database schema (anything in `database/` or table structure)
- Make small, focused changes and explain what changed
- Do not touch files outside `/var/www/html`

## Definition of done

- `php8.4 -l` passes for every changed PHP file
- Feature works at http://localhost/
- No PHP warnings or notices
- UI text in English
