## 2026-08-03 09:23 — Cardo replaces Share Tech; header pill covers scrolled content

### Context
Two requests:

1. Drop Share Tech (added an hour earlier) and use Cardo instead, applying
   it to everything that was Instrument Serif italic — not just the hero
   tagline.
2. "Increase header width so it can cover the contents on the body when I
   scroll down." The hero name was visible past the pill's edges while
   scrolling.

Share Tech survived exactly one commit. A technical sans used once, beside
four Instrument Serif italic leads, read as an inconsistency rather than an
accent. Cardo unifies all of it under one italic voice.

### Changed
**Fonts** — bundle now 132 KB across five files.
- Added `Cardo-Regular.woff2` (15.1 KB) and `Cardo-Italic.woff2` (18.5 KB).
- Deleted `ShareTech-Regular.woff2` and `InstrumentSerif-Italic.woff2`.
- `OFL.txt` copyright line swapped to David J. Perry.

**`theme.json`**
- `tech` slug removed; `lead` slug added (Cardo, roman + italic).
- `display` family reduced to the roman face only.
- `core/quote` and `core/pullquote` moved from `display` to `lead`;
  quote line-height 1.35 → 1.4 for Cardo's metrics.

**`style.css`**
- Five selectors now use `lead` + italic: `.hero__tagline`,
  `.chapter-lead`, `.work-card__tagline`, `.memory-note__text`,
  `.contact__eyebrow`. The two roman `display` users, `.about__prose > p`
  and `.contact__address`, are untouched.
- `.hero__tagline` reverts to italic; keeps `x-large`, line-height 1.35,
  measure 34ch.
- `.site-header__pill` `max-width: 1150px` →
  `var(--wp--style--global--wide-size)`.
- `--c-glass` opacity 0.86 → 0.96 in both schemes.
- New `.site-header.is-scrolled::before` — a 0.75rem paper strip filling
  the gap between the viewport top and the pill.

### Verification
`http://localhost:8080`, 1440×900, both schemes, no console errors.

Registered faces, from `document.fonts`:

```
Cardo 400 italic
Cardo 400 normal
Instrument Serif 400 normal
Inter 400 600 normal
JetBrains Mono 400 500 normal
```

No Share Tech, no Instrument Serif italic. Every `fontFace` src in
`theme.json` checked against the filesystem — all five present.

Family audit by script, walking each `font-family` declaration back to its
selector: all five `lead` consumers have `font-style: italic`; both
`display` consumers do not.

Pill alignment: pill `[130, 1310, 1180]`, content `[130, 1310, 1180]` —
exact. At scrollY 190 the hero name is no longer legible through or beside
the pill, and nothing crosses the top edge.

`theme.json` parses; CSS comment nesting and brace balance script-checked.

### Rollback
`git revert` the three commits: `a0c6456` (Cardo + pill width), the glass
opacity fix, and the gap-fill fix.

### For LLMs
- **The italic/roman split is the rule now.** Every italic on the site is
  Cardo (`lead`); every upright serif is Instrument Serif (`display`).
  Do not set `font-style: italic` on a `display` selector — the italic
  face is no longer bundled and the browser will synthesise a slant.
- `document.fonts.check()` is not a reliable way to prove a font was
  removed. It returns true when the family is absent entirely and the
  check falls through to a system fallback. Enumerate `[...document.fonts]`
  instead; that lists only registered faces.
- The header pill reads `--wp--style--global--wide-size` rather than a
  literal 1180px, so changing `layout.wideSize` in `theme.json` keeps the
  pill and the content column aligned. Hard-coding it re-breaks the bleed.
- `--c-glass` is near-opaque (0.96) deliberately. Lowering it back toward
  0.86 makes headline-sized type legible through the blur again.
- The `.site-header.is-scrolled::before` strip is paper-on-paper and
  therefore invisible. It is not decoration — deleting it lets content
  slide across the very top of the viewport above the pill.
