## 2026-08-03 20:42 — Step the second memories column down a half step

### Context
Vancouver was to start lower than Seoul but higher than The long way home,
with Desk following it down. That turns the board's two-level offset into
an even three-step cascade.

### Changed
**`style.css`**
- New `.memory-plate--offset-sm`, sharing the transform and
  bottom-margin rule with `.memory-plate--offset`.
- The two depths read from one source: `--offset` is
  `var(--wp--preset--spacing--70)` (56px) and `--offset-sm` is that
  value halved (28px). Deriving rather than hard-coding means retuning
  one cannot leave the cascade uneven.
- Both classes are switched off under 900px.

**`patterns/section-memories.php`** — Vancouver carries `--offset-sm`.

### Verification
1440×900, no console errors.

```
column   first tile           top    drop from Seoul
1        Seoul                2930    0
2        Vancouver            2958   28
3        The long way home    2986   56

constraint: 2930 Seoul < 2958 Vancouver < 2986 Long way home  — satisfied
```

Desk followed Vancouver down by the same 28px, 3327 → 3355. Somewhere
between is unchanged at 3214.

Narrow widths, both offsets off as intended:

```
800px  cols=2  offset none  offset-sm none
390px  cols=1  offset none  offset-sm none
overflow-x: none at both
```

### Rollback
`git revert adfe8e1`. Vancouver returns level with Seoul.

### For LLMs
- The cascade is 0 / 28 / 56 and is meant to stay even. `--offset-sm` is
  `calc(var(--wp--preset--spacing--70) / 2)`, not a literal — changing
  spacing-70 moves both steps together. Do not replace the calc with a
  fixed value.
- Both offset classes use `transform` plus extra `margin-bottom`, never
  `margin-top`. Multicol discards a margin that lands on a column
  boundary; see the 20:38 fragment for the full account.
- The offsets are a three-column device and are disabled under 900px.
  Adding a third depth means adding it to the disable rule too.
