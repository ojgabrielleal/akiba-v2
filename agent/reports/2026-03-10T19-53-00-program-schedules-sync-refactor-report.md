---
title: Program Schedules Sync Refactor
date: 2026-03-10
description: Implementation of a manual synchronization logic for program schedules to handle CRUD operations in a single request.
---

# Report: Program Schedules Sync Refactor

**Objective:** Enable full synchronization (Add, Update, Delete) of `ProgramSchedule` records through the `RadioController@updateProgram` method, mimicking the behavior of a `sync()` method for `hasMany` relationships.

## Actions Taken

### 1. Logic Implementation
The `updateProgram` method was modified to handle the `schedules` input array using the following steps:
- **Collection & Pluck**: Converted the input to a Laravel Collection and extracted all `uuid` values.
- **Cleanup (Delete)**: Used `whereNotIn` with the extracted UUIDs to remove any schedules no longer present in the payload.
- **Upsert (Update or Create)**: Iterated through the array using `updateOrCreate` to ensure new items are added and existing ones are updated.

### 2. Code Refactoring
Removed unnecessary `Log::info` and structured the sync logic to be atomic and readable.

## Final Result
The synchronization is now efficient and prevents orphaned records in the `programs_schedules` table. It provides a seamless experience for the front-end when editing complex program structures.

**Modified File:**
- `app/Http/Controllers/Web/Private/RadioController.php`
