## 2026-08-03 09:40 — Scheme toggle alignment, wider About measure

### Context
Two reports against the rendered homepage:

1. "Theme button is slightly lower than the texts." The scheme toggle sat
   below the nav links in the header pill.
2. "Increase width of the content." The About prose was using half the
   column and reading as a narrow strip.

### Root cause of (1)
WordPress's flow layout emits, on every group block:

```
.wp-block-group > * + * { margin-block-start: <blockGap> }
```

`blockGap` resolved to 10.72px here. Inside a flex container that margin is
neither collapsed nor ignored — in flexbox a block margin offsets the item
**even under `align-items: center`**, because auto-margin resolution runs
before alignment.

Two elements were affected, compounding:

| Element | Was | Cause |
|---|---|---|
| `.site-header__end` | 5.4px below pill centre | 2nd child of `.site-header__pill` |
| `.scheme-toggle` | 5.3px below nav centre | 2nd child of `.site-header__end` |

This is the **third** bug from this one rule. The first was the work-card
tag chips staircasing; the second was the hero's every-line-at-a-different-
left-edge problem (the `!important` auto-margin variant).

### Changed
**`style.css`**
- New consolidated rule in section 02 listing every flex row assembled from
  a group block: `.chapter-rule`, `.site-header__pill`,
  `.site-header__end`, `.hero__actions`, `.work-card__tags`,
  `.contact__actions`. Replaces the two scattered per-component fixes,
  which are now deleted.
- `.about__prose > p` max-width 58ch → 82ch, line-height 1.55 → 1.65.

**`theme.json`** — `custom.header.height` 4.5rem → 5rem. Zeroing the stray
margin shrank the pill from 77px to 56px, making the real header box 80px.

### Verification
`http://localhost:8080`, 1440×900, no console errors.

Vertical centres in the header pill, before and after:

```
before   pill 50.7   title 40.0   navLink 56.1   toggle 61.4
after    pill 40.0   title 40.0   navLink 40.0   toggle 40.0
```

Offsets are now exactly 0. Work-card tag chips still share a top edge
(`[1988, 1988, 1988]`), confirming the consolidation did not regress the
earlier fix.

About prose 587px → 830px, 50% → 70% of the 1180px column.

Anchor clearance re-checked after the token change — every section lands at
112px against a header bottom of 68px:

```
about 112 · work 112 · notes 112 · memories 112 · contact 332 (page end)
```

`theme.json` parses; CSS comment nesting and brace balance script-checked.

### Rollback
`git revert` `393b60d` and the token commit.

### For LLMs
- **Any new flex or grid row built from a group block must be added to the
  margin-zeroing list in section 02 of `style.css`.** WordPress will put
  `margin-block-start` on its children and the row will misalign. This has
  now caused three separate visual bugs; the list exists so it stops
  happening.
- In flexbox, `align-items: center` does not neutralise a block margin on
  the item. Do not assume centring is enough.
- `ch` is the width of a zero, not an average character. Instrument
  Serif's zero is narrow, so 82ch renders around 100 actual characters per
  line — past the usual 45–75 comfort range. The 1.65 leading is
  compensating for that and should not be reduced without also narrowing
  the measure.
- `custom.header.height` is consumed only by `scroll-padding-top` in
  `style.css`. If the pill's padding or content height changes, re-measure
  and update the token, then re-check that every anchor still lands below
  the header.
