## 2026-08-04 02:00 — Country line on the rail, About prose back to serif

Branch: `update`.

### Context
Two asks: put the About prose back to the face it had before the mono
retune, and name the country after Seoul on the left rail.

### Changed
**About prose** — `git revert` of `ac19f28`. Back to `display`
(Instrument Serif) at `large`, 1.7 leading, 64rem measure. Rendered
check: `Instrument Serif 22px/37.4px, max-width 1024px`.

**`parts/header.html`** — the start label is now three lines:
`Seoul / South Korea / 37.5°N`. The end label is unchanged at
`Vancouver / 49.3°N`.

**`style.css`** — three coupled edits, none of which are optional:

1. `white-space: nowrap` on `.site-rail__label`. "SOUTH KOREA" sets
   79px against 68px of room inside the rail, so it wrapped to
   "SOUTH / KOREA" — which reads as a mistake rather than a stack.
2. Rail breakpoint 1360px → **1400px**. With nowrap the label ends at
   99px, past the 88px rail. Overhanging the page margin is fine;
   overhanging the text is not, and at 1360px the content column
   starts at 90px. Measured: 1360 → collides, 1400 → content at 110px,
   clear.
3. `--start` offset 2.75rem → **3.6875rem**. The old value centred a
   two-line label above the track; a three-line label hung 16px into
   it. The new value restores the original 14px gap.

### Verification
```
1360px   rail hidden (new breakpoint)
1400px   label 20→99px · 3 lines · 14px above track · content at 110 clear
1440px   label 20→99px · 3 lines · 14px above track · content at 130 clear
end      14px below track, unchanged
about    Instrument Serif 22px/37.4px, 64rem
```
No console errors.

### Rollback
`git revert` this commit. Reverting restores the mono About prose too,
since the revert of `ac19f28` is part of it — split the commit if only
one half is wanted.

### For LLMs
- **The rail breakpoint is a function of the longest label**, not of
  the rail width. It is 1400px because "South Korea" overhangs to 99px
  and the content column must start beyond that. Add a longer place
  name and recompute: label right edge < content left edge at the
  breakpoint, or the decoration lands on the prose.
- The two label offsets are deliberately different numbers now
  (3.6875rem vs 2.75rem) because the labels have different line counts.
  They are not a pair to keep in sync; they are each derived from their
  own label's height. One line at this size and leading is 0.9375rem.
- Vancouver has no country line. That asymmetry is as requested, not an
  oversight — adding "Canada" would need the same three-step treatment
  and would push the breakpoint again ("VANCOUVER" is already 65px).
