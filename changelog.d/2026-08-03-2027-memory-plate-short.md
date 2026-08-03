## 2026-08-03 20:27 — Shorten the Morning tile

### Context
The Morning tile was to be reduced in height: shorter than Somewhere
between, taller than Desk.

It was on `--square`, which Vancouver also uses, so retuning that modifier
would have moved a tile that was not meant to change. A new ratio was
needed rather than an edit to an existing one.

### Changed
- `style.css` — new `.memory-plate--short` at `aspect-ratio: 5 / 4`,
  slotted between `--square` (1/1) and `--wide` (4/3). Comment records the
  rendered height each ratio produces at the current column width.
- `patterns/section-memories.php` — Morning moved from `--square` to
  `--short`.

### Verification
1440×900, no console errors. All tiles are 385px wide, so height is
entirely aspect-driven:

```
Seoul              482px  (4/5, default)
Somewhere between  482px  (4/5, default)
Vancouver          385px  (1/1, --square)      unchanged
Morning            308px  (5/4, --short)       was 385px
Desk               289px  (4/3, --wide)
The long way home  289px  (4/3, --wide)

ordering: 289 Desk < 308 Morning < 482 Somewhere between
```

### Rollback
`git revert` this commit. Morning returns to `--square`.

### For LLMs
- The four ratios are a deliberate ladder, tallest first: default 4/5,
  `--square` 1/1, `--short` 5/4, `--wide` 4/3. Each is used by more than
  one tile, so retuning a modifier moves every tile that carries it. To
  change one tile, move it to a different modifier or add a new one.
- **Verification caching bit hard here.** The browser served a stale DOM
  showing `memory-plate--square` while `curl` of the same URL returned
  `memory-plate--short` and the CSS on disk had the rule. A screenshot
  taken in that state showed the old 385px height and looked like the
  change had failed. `?cache-buster` on the URL was not enough; the browse
  daemon had to be restarted to clear it. When a visual check disagrees
  with a DOM measurement taken moments earlier, suspect the browser before
  the code, and confirm against `curl` plus the file in the container.
