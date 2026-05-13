<div align="center">
  <img src="https://i.imgur.com/WbKAm6A.png" alt="Akiba V2" width="500" />
</div>
<br/>

Language: [Português BR](README.md) | [English US](README.en-US.md)

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

- Docker
- Docker Compose

## Installation

Clone the repository and run the installation script:

```bash
git clone <repository-url>
cd akiba-v2
./scripts/install.sh
```

The script prepares the Docker environment, creates `.env` when needed, installs PHP and JavaScript dependencies, generates the application key, runs migrations, and seeds the database.

The local administrator user created by the seeder is:

```text
Username: admin
Password: admin
```

## Development

Start the project with:

```bash
./scripts/server.sh up
```

The script starts the containers and runs Laravel and Vite with the flags needed for host access.

Local links:

```text
Site:       http://localhost:8000
Panel:      http://localhost:8000/panel
phpMyAdmin: http://localhost:8080
```

To stop the project:

```bash
./scripts/server.sh down
```

To restart:

```bash
./scripts/server.sh restart
```

## Useful Scripts

The scripts in `./scripts` avoid typing `docker compose exec` manually:

```bash
./scripts/install.sh
./scripts/server.sh up
./scripts/server.sh down
./scripts/laravel.sh php artisan migrate
./scripts/laravel.sh php artisan test
./scripts/node.sh npm install
./scripts/node.sh npm run build
./scripts/composer.sh require vendor/package
./scripts/shell.sh
./scripts/shell.sh node
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

After installation, review the `.env` file to configure the radio integrations. The project includes environment variables for the radio stream URL, stream metadata, and Discord webhook support:

```env
CAST_URL=null
CAST_METADATA=null
DISCORD_LOCUTION_WEBHOOK=null
```

Set `CAST_URL` and `CAST_METADATA` to connect the app to the real radio stream and metadata shown by the player. Set `DISCORD_LOCUTION_WEBHOOK` to enable Discord webhook notifications when a broadcaster goes live.

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
