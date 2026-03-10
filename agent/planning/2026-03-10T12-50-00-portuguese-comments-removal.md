---
goal: "Standardize codebase to international standards by removing Portuguese comments."
date: 2026-03-10
---

# Planning: Portuguese Comments Removal

## Proposed Changes

### Cleanup
- Scan project for comments containing Portuguese characters.
- Files to clean: `HomeProvisoryController.php`, `UserSeeder.php`, `OnairSeeder.php`, `app.js`.

### Preservation
- Keep Discord webhooks content (Portuguese).
- Keep User-facing exceptions/errors (Portuguese).

## Verification Plan
- Run grep search for special characters in comments.
- Verify that functional strings remain intact.
