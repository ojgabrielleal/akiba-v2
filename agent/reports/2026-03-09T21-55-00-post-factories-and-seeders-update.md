---
title: Factories and Seeders Update for Posts
date: 2026-03-09
description: Detailing updates in PostSeeder and PostFactory to ensure 3 references and 3 categories per Post
---

# Factories and Seeders Update

**Objective:** Ensure every created post has at least 3 categories and 3 research references linked to it, as required.

## Modified Files
1. `database/seeders/PostSeeder.php`
2. `database/factories/PostFactory.php`

## Detailed Modifications

### 1. Update of `PostSeeder.php`
- Located the initial block (5 posts for ID 1) and the random block (15 posts).
- In both places, established instances `has(PostReference::factory()->count(...))` were configured with a count of **3**.
- Similarly, categories via `has(PostCategory::factory()->count(...))` were also updated to require a count of **3**.

### 2. Update of `PostFactory.php`
- Created and implemented the `configure()` method providing an `afterCreating` hook for the Post model instance.
- Inside this hook, the code dynamically retrieves the `categories` and `references` relations immediately after saving the Post.
- If the factory detects that a Post was instantiated with fewer than the predefined 3 relations, it uses its respective factories (`PostCategory::factory`, `PostReference::factory`) linked to the internal `$post->saveMany(...)` call to fill the remaining gaps.

## Expected Results
- Any instantiation via seeders, tinker interactions, or test routines guarantees the correct construction of at least 3 categories and 3 references for every new post created.
- No null-pointer bugs should occur in frontend editing due to missing relations, as they are always supplied by the Factory.
