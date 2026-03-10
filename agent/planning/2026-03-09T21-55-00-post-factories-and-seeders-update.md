---
goal: "Ensure every Post has at least 3 categories and 3 research references."
date: 2026-03-09
---

# Planning: Post Factories and Seeders Update

## Proposed Changes

### Seeders
- `PostSeeder`: Update `has()` counts to 3 for both categories and references.

### Factories
- `PostFactory`: Implement `configure()` with `afterCreating` hook to dynamically ensure the 3/3 count requirement if not met during instantiation.

## Verification Plan
- Run tests and seeders.
- Check database for relationship counts per post.
