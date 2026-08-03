## 2026-08-03 19:37 — About prose restyled; spacing scale was never applied

### Context
Requested for the About prose: restore the serif face, give it a colour
between the heading and the italic lead, add space above it, and widen it.

Implementing the "space above it" part surfaced a much larger bug: the
theme's entire spacing scale had never been in effect.

### The spacing bug
`settings.spacing.spacingSizes` was being **merged** with WordPress's
built-in scale, and the built-ins won every slug present in both. Only
slug `10` survived, because WordPress has no default for it.

| Slug | Emitted | Declared |
|---|---|---|
| 20 | 0.44rem | 0.75rem |
| 30 | 0.67rem | 1.5rem |
| 40 | 1rem | 3rem |
| 50 | 1.5rem | 6rem |
| 60 | 2.25rem | 9rem |
| 70 | 3.38rem | 12rem |

Every `var(--wp--preset--spacing--NN)` in the theme — root padding,
blockGap, card padding, chapter padding — had been resolving to roughly a
third of its intended value since the token layer was written. Chapters
were padded 36px where the design called for 144px.

Fixed with `defaultSpacingSizes: false` (WP 6.6+; the container runs
6.9.4). Desktop page height went 4483px → 6237px as a result.

### Changed
**`theme.json`**
- `settings.spacing.defaultSpacingSizes: false`.
- New palette slug `ink-soft`: `#3A4049` light, paired with `#C9BFB0`
  dark in `style.css`.

**`style.css`**
- `.about__prose` gains `padding-top: var(--wp--preset--spacing--40)`.
  Padding, not margin — see below.
- `.about__prose > p`: back to the display serif, `color: ink-soft`,
  `max-width: 64rem` (was 58ch), `line-height: 1.7`.
- `.chapter` padding drops from spacing-60 to spacing-50 under 700px.
- Dark scheme block gains `--wp--preset--color--ink-soft`.

**`CLAUDE.md`** — palette table updated; documents the three-rung text
ladder.

### Verification
Text colour ladder, L\* and contrast against each scheme's background:

```
LIGHT on #FDF6ED                     DARK on #14120F
  ink       #14161A  L* 7.2  16.89:1   ink       #F2EBE0  L* 93.3  15.79:1
  ink-soft  #3A4049  L* 26.9  9.74:1   ink-soft  #C9BFB0  L* 77.8  10.29:1
  muted     #6B7280  L* 47.9  4.51:1   muted     #9A9187  L* 60.7   6.03:1
```

`ink-soft` sits within 1 L\* of the exact midpoint in both schemes
(27.6 light, 77.0 dark) and all three clear AA.

Layout: prose 1024px wide, centred (78px each side), 96px gap below the
lead. Anchors still land at 112px, clear of the 68px header bottom.
Mobile 390px: no horizontal overflow, 7837px tall. No console errors.

### Rollback
`git revert` `2ddbdb0` to restore WordPress's spacing defaults — but note
that leaves `theme.json` declaring a scale it does not use.

### For LLMs
- **`spacingSizes` in `theme.json` does nothing without
  `defaultSpacingSizes: false`.** WordPress merges its own scale in and
  wins any slug collision. The same trap exists for `fontSizes`
  (`defaultFontSizes`) and colours (`defaultPalette`), both of which this
  theme already sets to `false`. If a token's computed value does not
  match its declaration, check for a default-merge setting first.
- **Use `padding`, not `margin`, to space a group block from its
  sibling.** WordPress emits
  `.wp-block-group.is-layout-flow > * { margin-block-start: <blockGap> }`
  at specificity (0,2,0), which beats a single-class rule at (0,1,0) — the
  margin is silently discarded. This is the fourth bug from WordPress's
  layout CSS; see also the flex-row list in section 02 and the hero's
  flow-vs-constrained note.
- The prose measure is in `rem` deliberately. `ch` is the width of a zero
  and rescales whenever the family changes, which resized this paragraph
  twice before the switch.
- 64rem is ~100 characters per line, past the usual comfort range. The 1.7
  leading is what carries it. Narrowing one without the other breaks the
  balance.
