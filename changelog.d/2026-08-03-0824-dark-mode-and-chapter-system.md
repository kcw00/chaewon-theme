## 2026-08-03 08:24 — Dark scheme, chapter system, site rail, consolidated JS

### Context
The theme was light-only and had no shared vocabulary for laying out a
section. Every section would have reinvented its own heading treatment. This
lays the foundation the six content sections are built on.

### Changed
**`style.css` — rewritten around four numbered concerns plus a motion floor.**

- Dark scheme. `html[data-theme="dark"]` redefines the six
  `--wp--preset--color--*` properties that `theme.json` emits on `:root`.
  Every block that references a palette slug flips, including core blocks the
  theme never touches. No per-component dark rules exist and none should be
  added.
- Semantic aliases `--c-veil`, `--c-glass`, `--c-tint` for translucent
  surfaces, defined per scheme.
- Base: smooth scroll with `scroll-padding-top` so anchors clear the fixed
  header, `text-wrap: balance` on headings, `pretty` on paragraphs, animated
  background-image link underline (scoped to prose only), `.link-arrow`,
  `.label` with `--dot` and `--chip` variants.
- Chapter system: `.chapter`, `.chapter-rule` (number, hairline, label, meta
  chip), `.chapter-title`, `.chapter-lead`. The connecting hairline is a
  `::before` on the label, so it fills exactly the gap at any viewport with
  no JavaScript.
- Site rail: fixed hairline down the left edge with a scroll-tracking dot,
  gated behind `@media (min-width: 1360px)`.
- Version 0.1.0 → 0.2.0. `Text Domain: chaewon` → `chaewon-theme`.

**`functions.php`**
- `chaewon_color_scheme_bootstrap()` on `wp_head` priority 0. Inline blocking
  script that sets `data-theme` from localStorage, falling back to
  `prefers-color-scheme`.
- `chaewon_skip_link()` on `wp_body_open`.
- `chaewon_setup()`: `responsive-embeds`, `align-wide`, text domain load.
- `chaewon_register_pattern_categories()`: a `chaewon` category.
- Block styles: group `card` / `card-quiet`, paragraph `label`.
- `CHAEWON_SCHEME_KEY` constant, mirrored in `site.js`.

**`assets/js/site.js` (new), `assets/js/reveal.js` (removed)**
- Scheme toggle: click handling, `aria-pressed` and `aria-label` sync,
  localStorage persistence, live OS-preference following *only* when no
  explicit choice is stored.
- Scroll reveal: unchanged behaviour, moved here.
- Scroll progress: writes `--scroll-progress` (0–1) on `:root`.
- Header `is-scrolled` state past 24px.
- One scroll listener for the last two, rAF-throttled, passive.

### Verification
- `node --check assets/js/site.js` passes.
- `php -l` on `functions.php` and `patterns/section-work.php` inside
  `chaewon-wp-wp-1` (PHP 8.3.31): no syntax errors.
- Dark palette contrast against `paper` `#14120F`: `ink` `#F2EBE0` 15.79:1,
  `signal` `#7FB79E` 8.16:1, `muted` `#9A9187` 6.03:1. All clear AA.

### Rollback
`git revert <sha>`. Restores `reveal.js`; `parts/` and `templates/` do not yet
reference anything introduced here, so nothing else breaks.

### For LLMs
- **Do not weaken the dark selector.** `html[data-theme="dark"]` has
  specificity (0,1,1), which beats `:root` (0,1,0). WordPress prints global
  styles inline in `<head>` and the theme stylesheet is a separate enqueue;
  their relative order is not guaranteed. A bare `[data-theme="dark"]` ties
  dark mode to that order and it will eventually break.
- **The scheme bootstrap must stay inline and blocking on `wp_head` priority
  0.** Deferring it or moving it to `site.js` reintroduces a flash of light
  before the swap.
- `--scroll-progress` is written by `site.js` and read only by the rail's
  `::after`. It has a `0` fallback in `var()`, so a JS failure parks the dot
  rather than breaking layout.
- The rail's 1360px breakpoint exists in CSS only, on purpose. 1180px content
  plus two 88px rails is 1356px; below that the rail overlaps content.
  Do not add a matching breakpoint in JS.
- Adding a colour to `theme.json` means adding its dark counterpart in
  section 01 of `style.css`. There is no automatic derivation.
