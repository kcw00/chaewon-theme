## 2026-08-03 20:02 — Project card lift and shadow bloom; halve the About gap

### Context
Two requests: halve the gap between the About sub-heading and its body,
and add a lift-and-bloom hover interaction to the four project cards
without changing the card's resting design.

### Changed
**About gap**
- `.about__prose` padding-top spacing-80 → spacing-60. Gap 96px → 52px.
- `theme.json` — dropped the `80` step; nothing referenced it any more.

**`patterns/section-work.php`**
- Each eyebrow is now wrapped in a `work-card__meta-row` group holding the
  label and an `aria-hidden` arrow span.
- Each card title is wrapped in `<a class="work-card__link">`.
  **All four point at `https://github.com/kcw00` as a placeholder** — they
  need real project URLs.

**`style.css`**
- `.work-card` gains `position: relative`, a resting
  `box-shadow: 0 1px 2px rgb(30 25 20 / 0.05)`, and the specified
  transitions. Background, border, radius, padding, and type are unchanged.
- `.work-card__link::after` is stretched over the card.
- `.work-card__meta-row` is flex, `space-between`; added to the
  margin-zeroing list in section 02.
- `.work-card__arrow` at eyebrow size, ink at 50%, `font-variant-emoji: text`.
- Hover and `:has(.work-card__link:focus-visible)` share one rule block:
  `translateY(-8px)`, `0 20px 36px -16px rgb(30 25 20 / 0.28)`, border
  darkened 8% toward ink, arrow `translate(5px, -5px)` to full ink.
- Focus ring on the card; the inline link's own outline is suppressed.
- `prefers-reduced-motion` drops both translates, keeps every colour and
  shadow change.

### Verification
1440×900, both schemes, no console errors.

```
cards 4 · arrows 4 · links 4 · links per card [1,1,1,1]
arrow aria-hidden="true" · interactive tag pills 0
elementFromPoint at centre / near tags / top-right / body → A.work-card__link

resting   shadow rgba(30,25,20,0.05) 0 1px 2px
hover     transform matrix(1,0,0,1,0,-8)
          shadow rgba(30,25,20,0.28) 0 20px 36px -16px
          arrow  matrix(1,0,0,1,5,-5), colour rgb(20,22,26)
focus     focus-visible true, card outline 2px solid rgb(47,111,94),
          same transform and shadow as hover
neighbours during hover: matrix(1,0,0,1,0,0) — unmoved
layout (offsetTop/Left/Width/Height) unchanged; grid height delta 0
reduced-motion simulated: transform none, shadow and colours still applied
dark scheme: transform -8px, arrow 50% → full ink
mobile 390px: no horizontal overflow, arrows render, About gap 52px
```

### Rollback
`git revert` the three commits (`af2e88b`, the reveal-compose fix, and the
arrow presentation fix).

### For LLMs
- **The lift composes with the reveal animation through a variable.** The
  grid is a `.reveal-stagger`, and its settled rule
  (`.js-reveal-ready .reveal-stagger.is-visible > *`) is (0,3,0) while
  `.work-card:hover` is (0,2,0). The settled rule now reads
  `translateY(var(--reveal-settled-y, 0px))` and the card sets that
  variable, so both survive. Changing the settled rule back to
  `transform: none` silently kills the lift — shadow and arrow keep
  working, which makes it look like a timing bug rather than a cascade one.
  The card sets *both* the variable and a plain `transform` on purpose:
  the settled rule only exists once JavaScript has run.
- **U+2197 defaults to emoji presentation on Apple platforms.** It renders
  as a blue tile that ignores `color` and the transition. The markup
  appends U+FE0E and the CSS sets `font-variant-emoji: text`; keep both.
- The whole card is clickable via a stretched `::after` on the title link,
  not by wrapping the card in an anchor. That keeps exactly one link per
  card in the accessibility tree, named by the project, and keeps the
  pattern editable as normal blocks. The trade-off is that text inside a
  card cannot be selected.
- **Verification trap, twice now:** the browser served a stale parsed
  stylesheet while `fetch()` of the same URL returned the new text, which
  made a working rule look broken. Compare the `?ver=` on the `<link>`
  against `stat -c %Y` of the file in the container before concluding the
  CSS is wrong.
