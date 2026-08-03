## 2026-08-03 20:38 — Panorama ratio and a staggered third column

### Context
Two requests on the memories board: make The long way home shorter than
the tile beside it, and start it lower down the page so the third column
does not begin on the same line as the other two. Somewhere between moving
down with it was explicitly fine.

### Changed
**`style.css`**
- New `.memory-plate--panorama` at `16 / 9` (385 → 217px). Added rather
  than retuning `--wide`, which Desk also uses.
- New `.memory-plate--offset`: `translateY(3.5rem)` plus a matching extra
  `margin-bottom`.
- The offset is switched off under 900px.

**`patterns/section-memories.php`**
- The long way home carries both new modifiers.

### The margin that did nothing
The offset was written as `margin-top: var(--wp--preset--spacing--70)`
first. It computed correctly — `getComputedStyle` reported `56px` — and
moved the tile zero pixels.

Multicol truncates a margin that lands on a column boundary, and a tile
that *begins* a column is exactly that case. The margin existed, applied,
and was discarded at layout.

The working form is a transform for the visual move plus an equal addition
to `margin-bottom` so the flow accounts for it. Bottom margins between two
tiles inside the same column are not at a break, so they survive; that is
what brings Somewhere between down by the same amount and keeps the gap
below correct.

### Verification
No console errors.

```
1440px  cols=3  offset transform matrix(1,0,0,1,0,56)  column-top delta 56px
 800px  cols=2  offset transform none
 390px  cols=1  offset transform none
overflow-x: none at all three
```

Column tops at 1440: Seoul 2930, Vancouver 2930, The long way home 2986.
Somewhere between follows at 3214, 12px below the panorama tile's 3202
bottom — the standard block gap, unchanged.

Heights: Seoul 482 · Somewhere between 482 · Vancouver 385 · Morning 308 ·
Desk 289 · The long way home 217.

### Rollback
`git revert` the three commits. The tile returns to `--wide` at the top of
its column.

### For LLMs
- **`margin-top` does not work on a tile that starts a multicol column.**
  It computes and is then dropped at layout, so it looks like the rule
  never matched. Use `transform: translateY()` for the move and add the
  same amount to `margin-bottom` so following siblings account for it.
  Do not "simplify" this back to a top margin.
- The ratio ladder is now five deep, tallest first: default `4/5`,
  `--square` `1/1`, `--short` `5/4`, `--wide` `4/3`, `--panorama` `16/9`.
  Every modifier is shared by more than one tile, so changing a single
  tile means moving it to another modifier or adding one.
- `--offset` is a three-column device. It is disabled under 900px on
  purpose; in a single stack it reads as one tile in a hole.
