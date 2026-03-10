# Activity Authorship Correction

**Date:** 2026-03-09
**Time:** 21:17 (Brasília Time)
**Module:** Database / Seeders
**Title:** Authorship restriction in ActivitySeeder

## Summary of Changes
1.  **Administrative Restriction in Activities**
    *   In `ActivitySeeder`, dynamic generation of random authors (`User::inRandomOrder()->first()`) for the `Activity` model was removed.
    *   Multiple instances (15 records) were consolidated, all strictly pointed to the primary administrator user (`User::find(1)`) via the `for()` directive.
    *   This ensures that dashboard activities filled during seeding are uniquely correlated to the admin account, meeting new criteria for dashboard visualization and report manipulation solely by the administrator.

## Final Result
✅ No extra activities will be filled simulating other users in the database. The `php artisan migrate:fresh --seed` command will generate activities purely for the admin.
