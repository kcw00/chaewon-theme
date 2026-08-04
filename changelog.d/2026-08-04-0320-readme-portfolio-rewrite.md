## 2026-08-04 03:20 — README rewritten as the portfolio front door

### Context

The repo is being listed on a portfolio, so the README is now the first
thing a stranger reads. The previous README was a contributor manual —
install steps, pattern-cache workarounds, template hierarchy — and led
with none of the design or engineering decisions the theme actually
demonstrates.

### Changed

- `README.md` — rewritten. Leads with the project's premise (platform-
  native, no build step), then the design system (type, the no-sans
  decision, the seven-slug palette with light/dark values and the text
  ladder), then engineering notes: dark mode via custom-property
  redefinition and the specificity reasoning, fail-safe motion, the
  project post type and its computed block-binding source, the
  positional bento grid, and the CDN-safe cache busting. Reference
  material (anatomy table, homepage composition, template map, utility
  classes, install) follows. Contributor detail now points at
  `CLAUDE.md`.
- `CLAUDE.md` — gained the "New pattern files need a cache clear"
  section (the `delete_pattern_cache` reflection snippet), relocated
  from the old README so the operational trick is not lost. No other
  CLAUDE.md content changed.

### Verification

- Every claim cross-checked against source: palette hexes and font
  slugs against `theme.json`, dark-scheme values against the
  `html[data-theme="dark"]` block in `style.css`, binding source and
  rewrite-flush behaviour against `functions.php`, homepage composition
  against `templates/front-page.html`, utility classes against their
  selectors in `style.css`, font sizes (84 KB, OFL) against
  `assets/fonts/README.md`.
- Relative links (`CLAUDE.md`, `assets/fonts/OFL.txt`) confirmed to
  exist at those paths.

### Rollback

`git revert` the commit. The old README is fully preserved in history;
nothing outside the two markdown files was touched.

### For LLMs

`README.md` is public-facing portfolio material — keep its altitude
(decisions and reasoning, not operations). Operational and contributor
detail belongs in `CLAUDE.md`. The pattern-cache clearing snippet now
lives only in `CLAUDE.md` under "New pattern files need a cache clear".
The palette table exists in three places that must stay in sync when a
value changes: `theme.json` (source of truth), the dark block in
`style.css`, and the tables in `README.md` and `CLAUDE.md`.
