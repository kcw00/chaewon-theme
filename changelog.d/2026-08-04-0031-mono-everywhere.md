## 2026-08-04 00:31 — Mono everywhere, Inter removed

Branch: `update`.

### Context
Follows the story-in-mono change an hour earlier. Requested: every
remaining Inter surface moves to mono too. Rather than repoint the
`body` family, the family is gone — the site now has three faces and no
sans.

### Changed
**`theme.json`**
- The `body` fontFamily entry deleted, Inter `fontFace` with it.
- `styles.typography.fontFamily` → `var(--wp--preset--font-family--mono)`.
  This is the site default, so new content inherits mono with no
  per-selector work.
- `elements.button.fontFamily` → mono (it named `body` explicitly).
- `medium` preset `1.0625rem` → `0.9375rem`, fluid min `1rem` →
  `0.875rem`.
- Root `lineHeight` `1.65` → `1.8`, `letterSpacing` `-0.005em` → `0`.

The size and leading are compensations, not taste. A monospace at a
sans's size reads optically larger, and at a sans's leading it reads as
a code block. The negative tracking was an Inter correction and does
nothing useful on a monospace.

**`style.css`**
- `.project__visit .wp-block-button__link` was the only rule naming
  `--wp--preset--font-family--body`; now mono.
- The `.project__body > p` rule from the previous commit folded away —
  family, size, and leading all come from the root now. What is left on
  `.project__body > p, > ul, > ol` is the measure and the prose colour.

**`assets/fonts/Inter-Variable.woff2` deleted** (48 KB). Font payload
132 KB → 84 KB. `assets/fonts/README.md` and `CLAUDE.md` updated to
match.

### Verification
Every text-bearing visible element, tallied by rendered family:

```
page                 JetBrains Mono   Instrument Serif   Cardo   Inter
/                          73                17            10      0
/projects/                 99                11            11      0
/projects/minion/          66                 1             1      0
/writing/                  16                 2             1      0
/hello-world/              14                 1             0      0
```

Three families, no fallback leaking through — a dangling
`--wp--preset--font-family--body` would have shown up here as a serif
default, and does not.

Inter is gone from the container, not just the repo:

```
container fs   Inter-Variable.woff2 absent
HTTP           /assets/fonts/Inter-Variable.woff2 → 404
page CSS       0 occurrences of "Inter-Variable"
```

The browse network log showed a cached 200 for that URL; `curl` is the
ground truth and returns 404.

Checked at 1440px and 390px, both schemes, no horizontal overflow on
`/`, `/projects/minion/`, or `/writing/`. No console errors.

About prose is untouched — it was already Instrument Serif at `large`,
which is why it never appeared in the Inter audit.

### Rollback
`git revert` this commit. It restores the font file, the family, the
preset sizes, and the docs together, which is the point of doing them in
one commit.

### For LLMs
- **There is no `body` font family and no
  `--wp--preset--font-family--body` custom property.** A rule still
  referencing that variable resolves to nothing and the element drops to
  the browser default, which looks like Times. Grep before adding one.
- `medium` is now *the mono body size*. Three other rules consume it —
  `.link-arrow`, `.notes-row__arrow`, `.project__visit` button — plus
  `elements.h5` and `elements.button`. Changing it moves all of them.
  `h5` is unused in this theme.
- Root `lineHeight: 1.8` and `medium: 0.9375rem` are a pair. Raising one
  without the other is what makes long-form mono unreadable.
- Headings were never affected: `x-large`, `xx-large`, and `display` are
  separate presets and nothing in `styles` sizes in `em`, so there is no
  cascade from the root size change.
- `OFL.txt` still carries Inter's copyright line, deliberately. Stripping
  a notice out of a bundled licence is not a tidy-up worth making.
