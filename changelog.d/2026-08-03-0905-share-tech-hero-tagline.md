## 2026-08-03 09:05 — Share Tech for the hero tagline

### Context
The hero tagline was set in Instrument Serif italic, the same face as every
other lead on the page. Requested change to Share Tech
(https://fonts.google.com/specimen/Share+Tech), a single-weight technical
sans, to give the one line that states the job its own voice.

The site rail coordinates were confirmed as staying — no change there.

### Changed
**`assets/fonts/ShareTech-Regular.woff2`** — new, 8.5 KB, latin subset,
weight 400. Brings the bundle to 117 KB across five files.

**`theme.json`** — fourth family registered under the `tech` slug:

```
"slug": "tech",
"fontFamily": "\"Share Tech\", ui-monospace, SFMono-Regular, sans-serif"
```

Registering it here rather than writing a bare `@font-face` in `style.css`
means it also appears in the editor's font picker.

**`style.css`** — `.hero__tagline` now uses
`var(--wp--preset--font-family--tech)`. Dropped `font-style: italic`.
Size `large` → `x-large`, line-height 1.35 → 1.4, measure 34ch → 30ch.

**`assets/fonts/OFL.txt`** — added the Share Tech copyright line.
**`assets/fonts/README.md`**, **`CLAUDE.md`** — updated to four families.

### Verification
`http://localhost:8080`, both schemes, mobile 390×844, no console errors.

```
document.fonts.check('16px "Share Tech"')   true
registered face                              Share Tech 400 normal
computed family    "Share Tech", ui-monospace, SFMono-Regular, sans-serif
computed style     normal          computed weight  400
computed size      32px desktop / 24.65px at 390px
mobile overflow-x  none
```

`theme.json` parses; every `fontFace` src checked against the filesystem —
all five present.

### Rollback
`git revert 7358ef4`. The tagline returns to Instrument Serif italic.

### For LLMs
- **Share Tech ships one weight (400) and no italic.** Nothing using the
  `tech` family may set `font-weight` above 400 or `font-style: italic` —
  the browser synthesises them and the glyphs visibly skew. If a second
  weight is needed there, the font has to be replaced.
- `tech` is deliberately used in exactly one place (`.hero__tagline`).
  Every other tagline and lead on the page is still Instrument Serif italic:
  `.chapter-lead`, `.work-card__tagline`, `.memory-note__text`,
  `.contact__eyebrow`. Do not spread `tech` to those without being asked.
- Share Tech sets small for its point size and runs tight, which is why the
  tagline steps up a size and opens its line-height. Swapping the family
  back means undoing those three compensating values too.
- Adding a font family to `theme.json` does not need the pattern-cache
  flush that adding a new `patterns/*.php` file does. A plain reload picks
  it up.
