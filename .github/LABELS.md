# Akiba V2 Standard Labels

This document defines the labels used in the Akiba V2 repository and their purpose.

## Issue Type

| Label | Description | Color |
|-------|-------------|-------|
| `bug` | Error report or unexpected behavior | Red |
| `enhancement` | New feature or improvement | Green |
| `refactor` | Improvement to existing code | Orange |
| `documentation` | Documentation addition or improvement | Blue |
| `security` | Security issue | Red |
| `performance` | Performance improvement | Yellow |

## Code Area

| Label | Description | Color |
|-------|-------------|-------|
| `backend` | PHP, Laravel, or API changes | Blue |
| `frontend` | Svelte, JavaScript, or CSS changes | Purple |
| `database` | Database, migration, or seeding changes | Brown |
| `devops` | Infrastructure, CI, or deployment changes | Black |

## Status

| Label | Description | Color |
|-------|-------------|-------|
| `in-progress` | Work in progress | Orange |
| `blocked` | Blocked by a dependency, decision, or missing information | Red |
| `ready` | Ready to be developed | Green |
| `needs-review` | Waiting for review | Yellow |
| `in-review` | Currently under review | Yellow |

## Priority

| Label | Description | Color |
|-------|-------------|-------|
| `priority-critical` | Blocker or production is broken | Red |
| `priority-high` | High priority | Orange |
| `priority-medium` | Medium priority | Yellow |
| `priority-low` | Low priority and can wait | Green |

## Community

| Label | Description | Color |
|-------|-------------|-------|
| `help-wanted` | Looking for contributor help | Yellow |
| `good-first-issue` | Good for a first-time contributor | Green |
| `question` | Question | Blue |
| `discussion` | Open discussion | Purple |

## Decisions

| Label | Description | Color |
|-------|-------------|-------|
| `duplicate` | Duplicate of another issue | Gray |
| `wontfix` | Will not be fixed | Gray |
| `invalid` | Invalid or incorrect | Gray |
| `needs-more-info` | Needs more information | Yellow |

## How to Use Labels

When creating an issue, include one type label, one area label, one priority label when applicable, and any additional labels as needed.

Example for a new authentication feature:

- `enhancement`
- `backend`
- `security`
- `priority-high`

During review, update labels as the issue progresses: `ready` -> `in-progress` -> `needs-review` -> closed.
