## 2026-08-03 20:19 — Memories: all-image board with a hover zoom

### Context
The board mixed four photo placeholders with two written quote tiles.
Requested: make every tile an image card, and add a zoom on hover.

### Changed
**`patterns/section-memories.php`**
- Both `memory-note` tiles replaced with plates. The board is now six:
  two default (4/5), two `--square`, two `--wide`. Captions read Seoul,
  Morning, Vancouver, Desk, The long way home, Somewhere between.
- Pattern description updated.

**`style.css`**
- Deleted `.memory-note`, `.memory-note__text`, `.memory-note__source`.
  Nothing referenced them.
- `.memory-board .wp-block-image` and `.memory-plate` share one rule for
  `position: relative`, `overflow: hidden`, and the radius.
- The zoom scales the *contents*, not the tile: `img` for a real Image
  block, `::before` for a plate. Both `scale(1.06)` over 0.7s.
- `.memory-plate` background moved off the element onto `::before`, so
  there is a surface to scale that is not the border. Children lifted to
  `z-index: 1`.
- Fully disabled under `prefers-reduced-motion`.

### Verification
`http://localhost:8080`, no console errors.

```
board children  6   plates 6   memory-note 0
captions        Seoul · Morning · Vancouver · Desk ·
                The long way home · Somewhere between

hovered tile    ::before transform matrix(1.06, 0, 0, 1.06, 0, 0)
resting tile    ::before transform none
border          rest rgb(227,227,222) → hover rgb(47,111,94)
overflow        hidden
tiles whose geometry changed during hover: none

mobile 390px    6 plates, 1 column, no horizontal overflow
```

Server HTML checked with `curl` independently of the browser: 10
`memory-plate` matches (2 bare + 2×2 square + 2×2 wide), zero
`memory-note`.

### Rollback
`git revert` this commit. The two quote tiles and their CSS come back.

### For LLMs
- **The zoom is invisible on an empty plate.** A plate's surface is one
  flat colour, so scaling it against an identical background shows
  nothing; the border tint is the only visible feedback until real photos
  are added. The transform *is* applied and measurable. Do not "fix" this
  by adding a gradient to the placeholder — the flat-background decision
  is deliberate and documented.
- **The zoom scales contents inside a clipped frame, not the tile.**
  Scaling a tile in a `columns` masonry pushes it into the 12px column
  gap and visually collides with its neighbour. Verified that no tile's
  geometry changes during hover; keep it that way.
- `.memory-plate`'s background lives on `::before`, not on the element.
  Moving it back to the element removes the thing the zoom scales and
  silently kills the effect.
- Swapping a plate for a real Image block needs no CSS change; both are
  covered by the same selectors.
