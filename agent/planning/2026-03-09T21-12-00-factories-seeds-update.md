---
goal: "Improve factories and seeders with realistic data using Faker and expanding record counts."
date: 2026-03-09
---

# Planning: Factories and Seeders Update

## Proposed Changes

### Factories
- Use `fake()` for dynamic data in all factories (Activity, Calendar, Event, etc.).

### Seeders
- `UserSeeder`: Maintain `admin`/`admin` user and create 3 additional admins + dozens of diverse roles.
- Expand counts for all main seeders (Program, Post, Calendar, etc.).
- Update `OnairSeeder`: Ensure one `in_air => true` record pointing to a default `Automatic` model.
- Fix Foreign Key issues in `SongRequestSeeder` using dynamic lookups.

## Verification Plan
- Run `php artisan migrate:fresh --seed`.
- Verify database density and Admin UI.
