# changelog.d

One file per change. No flat `CHANGELOG.md` — a single prepended-to file means
every concurrent branch collides on the same lines, and resolving those
conflicts by hand loses entries.

## Naming

    <UTC-YYYY-MM-DD-HHMM>-<kebab-slug>.md

Generate the timestamp:

    date -u +"%Y-%m-%d-%H%M"

## Shape

```markdown
## YYYY-MM-DD HH:MM — one-line summary

### Context
Why this was needed. What was broken or missing.

### Changed
What actually changed, by file.

### Verification
How it was confirmed to work. Commands, URLs, what was observed.

### Rollback
How to undo it.

### For LLMs
What a future agent needs to know that isn't obvious from the diff.
```

## Rules

Append-only. Never edit or delete an existing fragment, including any
`_archive-*.md`. If a change was wrong, write a new fragment describing the
revert.
