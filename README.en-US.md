<div align="center">
  <img src="https://i.imgur.com/WbKAm6A.png" alt="Akiba V2" width="500" />
</div>
<br/>

Language: [Português BR](README.md) | [English](README.en-US.md)

Second version (2026) of Rede Akiba's news and web radio portal, bringing a renewed experience to fans of Japanese culture since 2016.

## About

Rede Akiba ( Akiba V2 ) is a Laravel application for managing a community and radio platform focused on anime culture. The project combines a public player experience with song requests and a private control panel for content, programming, live hosting, media, marketing assets, users, permissions, and operational tasks.

## Stack

- **Backend:** PHP 8.2, Laravel 12, Laravel Sanctum
- **Frontend:** Inertia.js, Svelte, Vite, Tailwind CSS 4
- **Database:** MySQL
- **Assets and media:** Intervention Image
- **Tooling:** PHPUnit, Laravel Pint, Laravel Pail

## Main Features

- Public page with a player and song request support
- Private panel with authentication
- Dashboard with activities and task completion
- Management for posts, reviews, events, podcasts, media, and marketing assets
- Radio management for programs, music rankings, listener of the month, and song requests
- Live hosting flow for starting and finishing broadcasts
- Administration area for users, roles, permissions, calendars, activities, tasks, and automatic programs
- Profile management
- Cast endpoints for stream redirects and metadata
- Discord webhook integration for stream events

## Requirements

- PHP 8.2+
- Composer
- Node.js and npm
- MySQL
- Redis is optional, depending on your local cache/session configuration

## Installation

Clone the repository and install the PHP and JavaScript dependencies:

```bash
composer install
npm install
```

Create the environment file and generate the Laravel app key:

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=akiba
DB_USERNAME=root
DB_PASSWORD=
```

Then run the migrations:

```bash
php artisan migrate
```

To prepare the database with initial data, run the seeders:

```bash
php artisan db:seed
```

For a fresh local environment, you can recreate the database and seed it in one command:

```bash
php artisan migrate:fresh --seed
```

The seeders create permissions, roles, users, activities, programs, content, podcasts, radio data, polls, song requests, and other development records. The local administrator user created by the seeder is:

```text
Username: admin
Password: admin
```

## Development

Run the full local development stack through the custom Artisan command:

```bash
php artisan dev
```

This starts the Laravel server, queue listener, Laravel Pail logs, and Vite dev server together.

You can also run each service separately:

```bash
php artisan serve
npm run dev
php artisan queue:listen
```

## Build

Create a production frontend build:

```bash
npm run build
```

## Tests

Run the test suite:

```bash
php artisan test
```

## Useful Routes

- `/` - provisional public home/player
- `/site` - public site route
- `/panel` - panel login
- `/panel/dashboard` - private dashboard
- `/panel/radio` - radio management
- `/panel/locution` - live hosting area
- `/panel/administration` - administration area
- `/api/cast` - cast stream redirect
- `/api/cast/metadata` - cast metadata

## Environment Notes

The project includes extra environment variables for stream and Discord integrations:

```env
CAST_URL=null
CAST_METADATA=null
DISCORD_STREAM_WEBHOOK=null
```

Set these values when you want to connect the local app to real stream metadata or webhook notifications.

## Project Structure

- `app/Actions` - application use cases grouped by domain
- `app/Console/Commands` - custom Artisan commands
- `app/Http/Controllers` - public, private, API, and provisional controllers
- `app/Http/Requests` - form request validation
- `app/Http/Resources` - API/resource response formatting
- `app/Models` - Eloquent models
- `app/Policies` - authorization rules
- `app/Services` - external and processing services
- `database/seeders` - initial data and development records
- `resources/js/pages` - Inertia/Svelte pages
- `resources/js/ui` - reusable UI components, layouts, and widgets
- `routes/web` - web routes split by context

## License

This project is open-sourced under the MIT license.
