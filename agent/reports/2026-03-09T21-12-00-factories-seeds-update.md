# Factories and Seeders Improvement and Realistic Data Insertion

**Date:** 2026-03-09
**Time:** 21:12 (Brasília Time)
**Module:** Database / Factories & Seeders
**Title:** Updating static data for Faker and creating additional records

## Summary of Changes
1.  **Faker PHP Generation**
    *   Reviewed system factories (such as `ActivityFactory`, `CalendarFactory`, `EventFactory`, `FrameworkFactory`, etc.).
    *   Identified that mandatory and literal static fields were already being handled by `fake()` instances. Where appropriate, literal strings were changed to `fake()->word()` or corresponding sentences.

2.  **Primary Administrator Implementation Maintenance**
    *   In `UserSeeder`, the user with credentials `admin` / `admin` and `administrator` role was strictly maintained for fluid testing and evaluation navigation in the UI.

3.  **Data Generation Expansion (Seeders) and Administrative Insertion**
    *   `UserSeeder` was refactored to not only generate the `admin` user but also 3 additional random administrators and dozens of users with varied system roles.
    *   In other seeders (e.g., `ProgramSeeder`, `PostSeeder`, `CalendarSeeder`, `ReviewSeeder`, `TaskSeeder`, etc.), the unit limiter (1 at a time) was replaced. Dozens of instances are now generated using the `count(N)` modifier.
    *   Relationships previously pointed to detached fake instances. Now, they actively use the administrator user (`User::find(1)`) so it has generated data for manipulation; the rest is distributed using random lookups among other users (`User::inRandomOrder()->first()`).

4.  **OnairSeeder Refactoring & Polymorphic Relationship (Automatic)**
    *   `OnairSeeder` fully met the requirement of having at least 1 result with `in_air` set to `true`, pointing the `program` association to `App\Models\Automatic`.
    *   This instantiated Automatic model was set with the `is_default` field strictly as `true`.
    *   Key coherence issues (`SongRequestSeeder` pulling literal IDs like `Onair::find(2)`) were replaced with dynamic loop lookups through current onairs, preventing Foreign Key breaks.

## Final Result
✅ Command `php artisan migrate:fresh --seed` finalized 100% with dense, truthful data and a testable base for Interface visualization focusing on the Admin profile.
