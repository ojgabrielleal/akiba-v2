---
goal: "Restrict Activity authorship to the administrator user in seeders."
date: 2026-03-09
---

# Planning: Activity Seeder Admin Restriction

## Proposed Changes

### Seeders
- `ActivitySeeder`: Change authorship from random users to strictly `User::find(1)` (Admin).
- Generate 15 activity records for the admin user.

## Verification Plan
- Run `php artisan migrate:fresh --seed`.
- Verify in database/UI that all activities belong to user ID 1.
