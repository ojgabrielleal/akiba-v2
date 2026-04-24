# GitHub Configuration

This directory contains GitHub configuration files and templates for the Akiba V2 repository.

## Files

### `ISSUE_TEMPLATE/`

Contains templates for standardized issues:

- `bug_report.yaml` - report bugs or unexpected behavior
- `feature_request.yaml` - suggest new features or improvements
- `task.yaml` - track general development or maintenance tasks
- `refactor.yaml` - propose code quality, architecture, or performance refactors
- `documentation.yaml` - request documentation additions or improvements
- `config.yaml` - configure issue templates and contact links

### `pull_request_template.md`

Default pull request template. It keeps PRs focused on:

- A clear goal
- A concise change summary
- Test instructions
- A verification checklist
- Related issues, PRs, or documentation

### `LABELS.md`

Reference for the repository label system.

## Language Guidelines

The repository uses English as its default public language. Use English for:

- README and project documentation
- Issue and PR templates
- Issue and PR titles
- Commit messages
- Labels and milestones
- Release notes

Because the team is fully Brazilian, day-to-day discussion inside issue or PR comments can be in Portuguese when it makes collaboration faster. Keep the title, summary, and final decision in English so the repository remains easy to scan later.

## Standard Labels

| Label | Description |
|-------|-------------|
| `bug` | Bug report or unexpected behavior |
| `enhancement` | New feature or improvement |
| `documentation` | Documentation additions or improvements |
| `refactor` | Code refactoring |
| `backend` | PHP, Laravel, or API changes |
| `frontend` | Svelte, JavaScript, or CSS changes |
| `database` | Database, migration, or seeding changes |
| `devops` | Infrastructure, CI, or deployment changes |
| `help-wanted` | Looking for contributor help |
| `good-first-issue` | Good task for a first-time contributor |
| `duplicate` | Duplicate of another issue |
| `wontfix` | Will not be fixed |

## How to Use

### Creating an issue

1. Go to "Issues" -> "New issue".
2. Choose one of the available templates.
3. Fill in the required fields.
4. Add at least one type label and one area label when possible.
5. Click "Submit new issue".

### Creating a pull request

1. Push your branch.
2. Open a "New pull request".
3. Describe the changes using the template.
4. Fill in the checklist.
5. Link the related issue with `Closes #123` when applicable.

## Best Practices

Use short, descriptive issue titles:

```text
Fix post loading error on the home page
Add dark theme support
Refactor post validation rules
```

Use clear sections when writing issues manually:

```markdown
## Description
[What is the issue or request?]

## Goal
[Why does this matter? What problem does it solve?]

## Tasks
- [ ] Step 1
- [ ] Step 2
```

For more details about contributing, see [CONTRIBUTING.md](../CONTRIBUTING.md).
