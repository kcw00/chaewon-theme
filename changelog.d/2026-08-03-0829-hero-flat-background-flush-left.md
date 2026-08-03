## 2026-08-03 08:29 — Hero: flat background, no coordinate pill, flush-left

### Context
Three problems, reported against the rendered homepage:

1. The coordinate pill above the name (`37.5°N 127.0°E › 49.1°N 122.8°W`)
   was not wanted.
2. The homepage did not have one background colour. A visibly lighter
   rectangle sat behind the upper half of the hero, with a hard seam where
   the section ended.
3. Found while fixing the above: every hero element sat at a different left
   edge. The name, tagline, body copy, and buttons were each centred
   independently, and the divider rule floated on its own mid-column.

### Changed
**`patterns/hero.php`**
- Removed the `hero__meta` paragraph.
- Group layout `constrained` → `default`.
- Description no longer mentions coordinates.

**`style.css`**
- Deleted `.hero::before`, its `html[data-theme="dark"]` variant, `.hero > *`,
  and `.hero__meta`.
- Deleted `overflow: hidden` from `.hero` (only existed to clip the wash).
- Deleted the `--c-veil` token — the pill was its only consumer.
- `.hero__divider` gained `margin-inline: 0`.

### Verification
At 1440×900 against `http://localhost:8080`, measured left edges:

```
hero 130 · h1 130 · tagline 130 · body 130 · actions 130 · divider 130
```

`getComputedStyle(.hero, '::before').content` is `none`. `document.body`
background is `rgb(253, 246, 237)` and `.hero` is `rgba(0, 0, 0, 0)`, so the
whole page paints one paper colour. Confirmed in both schemes; no console
errors. CSS comment blocks and braces balance-checked; `php -l` clean.

### Rollback
`git revert` the three commits `5744a72`, `681e9e1`, and the divider fix.

### For LLMs
- **The homepage is one flat colour on purpose.** Do not reintroduce a
  gradient, wash, or per-section background tint. At the opacities that look
  tasteful in isolation, the result reads as a mis-painted rectangle with a
  seam, not as atmosphere.
- **`patterns/hero.php` uses `"layout":{"type":"default"}` and that is
  load-bearing.** WordPress's constrained layout emits
  `margin-inline: auto !important` on every direct child. Inside a flex
  column, an auto cross-axis margin cancels `align-self: stretch`, so each
  child shrink-wraps to its own content and then centres itself. Switching
  the hero back to `constrained` silently re-breaks the left alignment, and
  the `!important` means CSS cannot cleanly override it. Any future
  flex-column section built from a group block hits the same trap.
- Several core blocks ship their own `margin-inline: auto`. `core/separator`
  is the one that bit here. Check computed margins before assuming a block
  inherits its parent's alignment.
