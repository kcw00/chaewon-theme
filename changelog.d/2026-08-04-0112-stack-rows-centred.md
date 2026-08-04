## 2026-08-04 01:12 — Stack rows centred again on the phone pages

Branch: `update`.

### Context
Feedback on the scoping pass: the 03 "Built with" rows were left on
the article's left edge, which reads unbalanced — a column of chips
hugging the left with the whole right half empty. Requested: the
skill set in the middle.

### Changed
**`style.css`** — the phone-page override
`.project__body:has(.project__phone) .stack-group { margin-inline: 0
!important }` removed. Nothing replaces it: the rows centre through
the constrained layout's own auto margins on every page, same as they
did before the phone work.

### Verification
1440px screenshots, all three phone pages:

```
minion, discord-bot   whole 03 sits below the phone; every row
                      centres in the full article width
smart-diagnosis       whole 03 sits beside the phone; every row
                      centres in the space left of it, matching
                      the prose treatment
```

Rows within each page all share one centre. No console errors.
No-phone pages unaffected (they never had the override).

### Rollback
`git revert` this commit.

### For LLMs
- This works because on each phone page the whole 03 section falls on
  one side of the float's bottom edge. A grid is a formatting-context
  root: beside the float it centres in the leftover space, below it
  in the full width. **If a future phone ends mid-03** — story
  shortened, image swapped for a taller one — rows above and below
  the seam will centre differently and the section will look
  staggered. The fix then is an explicit margin like the prose's
  centring calc, not zero margins (that was tried; it is what this
  change reverts).
- The prose keeps its explicit centring calc; only the stack rows
  went back to auto. They agree visually on smart-diagnosis because
  auto-centring in the float's leftover space and the calc's midpoint
  are the same geometry.
