## 2026-08-03 08:01 — Add CLAUDE.md and changelog.d, ignore .context

### Context
The repo had no contributor documentation and no changelog convention. Two
things were undiscoverable from the code alone:

1. WordPress is served by a Docker stack that lives *outside* this repo
   (`~/chaewon-wp/`), from a **separate clone** of this repository at
   `~/chaewon-wp/themes/chaewon-theme`. Editing files in a Conductor workspace
   has no effect on http://localhost:8080 until they land in that clone. Anyone
   who missed this would edit files and conclude the theme was broken.
2. `.context/` (Conductor's scratch directory) was tracked by git.

### Changed
- `CLAUDE.md` — new. Docker topology and the sync command, the load-bearing
  folder name, where each concern belongs, the palette table with dark values,
  how the dark-mode specificity trick works and why it must not be weakened,
  motion conventions, and the Site Editor override footgun.
- `changelog.d/README.md` — new. Fragment naming, required sections,
  append-only rule.
- `.gitignore` — added `.context/`.

### Verification
`git status` no longer lists `.context/`. `git check-ignore -v .context/todos.md`
resolves to the new rule.

### Rollback
`git revert <sha>`. Nothing else depends on these files.

### For LLMs
- The theme directory name `chaewon-theme` is load-bearing. WordPress resolves
  themes by directory name. `Text Domain:` in `style.css` must match it.
- To see changes at localhost:8080 from a workspace clone:

      git -C ~/chaewon-wp/themes/chaewon-theme fetch <workspace-path> <branch>
      git -C ~/chaewon-wp/themes/chaewon-theme checkout FETCH_HEAD

- `docker compose down -v` in `~/chaewon-wp` destroys the `dbdata` volume and
  with it every page, post, and Site Editor override. Plain `down` is safe.
