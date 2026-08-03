## 2026-08-03 09:00 — Drop chapter meta chips and journey coordinates

### Context
Two requests against the rendered homepage:

1. The boxed chip on the right of every chapter rule (`37.5°N → 49.3°N`,
   `2022 → now`, `Field observations`, `Seoul · Vancouver`, `The last page`)
   should go, on all five chapters.
2. The latitude and longitude beneath the city names in the journey line
   should go.

This continues the direction set by the hero fragment, where the coordinate
pill above the name was removed. The coordinate motif is being dialled back
to almost nothing.

### Changed
**All five `patterns/section-*.php`** — removed the `chapter-rule__meta`
paragraph. Each rule is now a number, a hairline, and a label.

**`patterns/section-about.php`** — removed both `journey__coord`
paragraphs. The stops are now just `Seoul, KR` and `Vancouver, CA`.

**`style.css`**
- Deleted `.chapter-rule__meta` and the `max-width: 700px` media query that
  hid it. Both unreferenced.
- Deleted `.journey__coord`, and the `display: flex` on `.journey__stop`
  that only existed to stack a place above a coordinate.
- Updated the section 03 header comment; its diagram still showed a chip.

### Verification
`http://localhost:8080`, no console errors.

```
metaChips     0
journeyCoords 0
chapterRules  ["01 About me", "02 Selected work", "03 Notes & writing",
               "04 Memories", "05 Say hello"]
journeyStops  ["Seoul, KR", "Vancouver, CA"]
```

Grep for `chapter-rule__meta` and `journey__coord` across css/php/html
returns nothing outside `changelog.d/`. `php -l` clean on all six patterns.
CSS comment nesting and brace balance verified by script.

### Rollback
`git revert f9c2710`.

### For LLMs
- The chapter rule is deliberately just `NN ──────── LABEL`. Do not
  reintroduce a trailing chip, a date range, or a coordinate.
- The coordinate motif now survives in exactly one place: the two
  `site-rail__label` elements in `parts/header.html`, which read
  `Seoul 37.5°N` and `Vancouver 49.3°N`. If a future request says to remove
  coordinates, that is the remaining instance.
- `.journey__stop` no longer needs to be a flex column; it holds a single
  paragraph. If a second line is ever added back, the flex column and gap
  have to come back with it.
