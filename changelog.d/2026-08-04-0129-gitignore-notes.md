## 2026-08-04 01:29 — ignore `notes/` (personal study notes)

### Context
The workspace convention is that substantive explanations get saved to
`notes/<YYYY-MM-DD>/<NN>-<topic>.md` for later study. Those are personal
notes, not theme source, and must never land in the repo.

### Changed
- `.gitignore`: added a `notes/` entry under its own comment.

### Verification
`git status --porcelain` after creating `notes/2026-08-03/…` shows no
untracked entries under `notes/`.

### Rollback
Delete the `notes/` line from `.gitignore`.

### For LLMs
`notes/` is scratch study material, parallel to `.context/`. Do not commit it,
do not reference it from theme files, and do not assume its contents describe
the theme — the first note in it reviews an unrelated project write-up.
