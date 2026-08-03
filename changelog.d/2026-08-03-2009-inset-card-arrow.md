## 2026-08-03 20:09 — Inset the project card arrow

### Context
On hover the ↗ travels 5px to the right into a 12px card padding, which
left it 8px from the border and looking cramped against the edge.

### Changed
`style.css` — `.work-card__arrow` gains `--arrow-travel: 5px` and
`margin-right: var(--arrow-travel)`. The hover rule's transform now reads
`translate(var(--arrow-travel), -5px)` instead of a literal `5px`, so the
inset and the travel cannot drift apart if either is retuned.

Nothing else changed: same glyph, size, colour, easing, and duration.

### Verification
1440×900, light and dark, no console errors. Distance from the arrow's
right edge to the card's right border:

```
              before    after
rest            13px     18px
hover            8px     13px
card padding    12px     12px
```

The hovered position now lands just past the padding edge rather than
inside it. Arrow transform still `matrix(1, 0, 0, 1, 5, -5)`.
Mobile 390px: 18px clearance, no horizontal overflow.

### Rollback
`git revert` this commit.

### For LLMs
- `--arrow-travel` is consumed twice: as `margin-right` on the arrow and
  as the X component of the hover transform. Changing one without the
  other reintroduces the crowding, which is why it is a variable rather
  than two literals.
- The inset is intentionally larger than the optical centre would suggest.
  A diagonal glyph reads as closer to an edge than a flat one at the same
  measured distance.
