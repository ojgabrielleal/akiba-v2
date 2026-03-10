---
goal: "Create unit tests for missing model relationships and standardize imports."
date: 2026-03-09
---

# Planning: Model Relationship Tests and Import Standardization

## Proposed Changes

### Tests
- Create `ActivityParticipantsTest`: Cover `confirmer` relation.
- Create `ProgramScheduleTest`: Cover `program` relation.
- Create `ReviewContentTest`: Cover `author` relation.
- Create `SongRequestTest`: Cover `onair` and `music` relations.

### Database
- Adjust Factories to handle `NOT NULL` constraints for `user_id`, `program_id`, and `activity_id`.

### Code Style
- Standardize imports to use `use App\Models\...` at the top of files instead of FQCN inline.

## Verification Plan
- Run `tests/Unit/Models`.
- Ensure all 53 validations pass.
