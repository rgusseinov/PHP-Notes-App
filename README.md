# PHP Notes App

A simple single-page notes application built with plain PHP and MySQL. It lets you create, list, edit,
and delete notes, each with a title, content, and timestamps.

## Requirements

- PHP 8.4
- MySQL 8.4

## Setup

1. Clone this repository.
2. Create the database and a MySQL user for it, e.g.:
   ```sql
   CREATE DATABASE notes_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'notes_user'@'localhost' IDENTIFIED BY 'change_me';
   GRANT ALL PRIVILEGES ON notes_app.* TO 'notes_user'@'localhost';
   ```
3. Apply the schema, then apply any migrations in `database/migrations/` in numeric order:
   ```sh
   mysql -u <user> -p notes_app < database/schema.sql
   mysql -u <user> -p notes_app < database/migrations/001_add_image_to_notes.sql
   ```
4. Copy `config.example.php` to `config.php` and fill in your database credentials:
   ```sh
   cp config.example.php config.php
   ```

## Running the app

The app is served by Apache from `/var/www/html`. Once set up, open `http://localhost/` in a browser.

## Project structure

```
index.php                  Single entry point — routing, form handling, and page rendering
src/
  Database.php              PDO connection (reads config.php, exposes a shared PDO instance)
  NoteRepository.php         Data access for notes (create, find, list, update, delete)
database/
  schema.sql                 Base table structure
  migrations/                Numbered SQL migrations applied after schema.sql, in order
assets/
  style.css                  Page styling
config.example.php          Template for config.php (committed)
config.php                  Database credentials (git-ignored, not committed)
CLAUDE.md                    Working rules and conventions for this project
```

## About this project

This project was built as a learning exercise for using Claude Code. `CLAUDE.md` documents the working
rules and conventions followed throughout.
