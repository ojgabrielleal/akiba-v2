---
title: Portuguese Comments Removal
date: 2026-03-10
description: Guide and report on scanning and removing Portuguese comments throughout the project for international standardization.
---

# Cleanup Report: Portuguese Comments Removal

**Objective:** Standardize the codebase by removing comments written in Portuguese, keeping only functional code and interface/log strings intended for the end-user or external integrations (Discord).

## Actions Taken

### 1. Project Scan
A global search (grep) was performed using regular expressions to identify special characters from the Portuguese language (`áéíóúâêîôûàèìòùãẽĩõũç`) within comment blocks (`//`, `/*`, `*`).

### 2. File Cleanup
The following files were identified and cleaned:

*   **`app/Http/Controllers/Web/Public/HomeProvisoryController.php`**: Removed comments regarding song string handling, artist extraction, and database logic.
*   **`database/seeders/UserSeeder.php`**: Removed comments describing the creation of administrators and regular users.
*   **`database/seeders/OnairSeeder.php`**: Removed comments regarding business rules for "In Air" records.
*   **`resources/js/app.js`**: Removed comments regarding Service Worker registration and Svelte application mounting.

## Preservation Considerations
To ensure the application did not lose functionality or context for the end-user, the following items were **NOT** removed:

*   **Discord Messages**: Content of webhooks notifying live streams.
*   **Exceptions and Errors**: Error messages thrown in `Exceptions` (e.g., "Nenhuma música foi selecionada").
*   **Interface Logs**: Messages appearing specifically for the user on the frontend or operational system logs describing states in Portuguese.

## Final Result
The code now presents a cleaner and more professional aesthetic, removing redundant native-language explanations that can be interpreted directly by reading the code (Clean Code).
