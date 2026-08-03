## 2026-08-03 19:45 — Retune the spacing scale back to the approved density

### Context
The previous fragment made `spacingSizes` actually apply by setting
`defaultSpacingSizes: false`. That was the right fix for the token layer,
but it tripled every spacing value at once and added air in places nobody
asked for:

- 96px between each chapter rule and its heading
- 144px of padding at the bottom of every section

The only gap that was meant to grow was the one above the About prose.

### Approach
Reverting `defaultSpacingSizes` would restore the density but put the
tokens back to being silently ignored — the exact landmine the previous
fragment removed. Instead the *values* were retuned so the scale is both
real and the density that was approved.

| Slug | Before this change | Now | What was rendering pre-fix |
|---|---|---|---|
| 10 | 0.5rem | 0.375rem (6px) | 8px |
| 20 | 0.75rem | 0.5rem (8px) | 7px |
| 30 | 1.5rem | 0.75rem (12px) | 10.7px |
| 40 | 3rem | 1rem (16px) | 16px |
| 50 | 6rem | 1.5rem (24px) | 24px |
| 60 | 9rem | 2.25rem (36px) | 36px |
| 70 | 12rem | 3.5rem (56px) | 54px |
| 80 | — | 5rem (80px) | new |

Steps 40–60 now match the pre-fix rendering to the pixel. Step 80 is new,
and exists solely for the one gap that was meant to grow.

### Changed
- `theme.json` — `spacingSizes` retuned as above; added slug `80`.
- `style.css` — `.about__prose` padding-top moved from spacing-40 to
  spacing-80, holding the gap at 96px.
- `style.css` — removed the `max-width: 700px` `.chapter` padding
  override. At 36px there is nothing left to trim on a phone.

### Verification
`http://localhost:8080`, no console errors.

```
                 rule → title    padding-bottom
about                    24px              36px
work                     24px              36px
notes                    24px              36px
memories                 24px              36px
contact                  24px              56px

About lead → prose       96px   (the one gap that grew)
page height            4255px   (was 6237px)
mobile 390px           5976px, no horizontal overflow, chapter pad 36px
```

### Rollback
`git revert 4a2607f`. That restores the 3x scale, not the WordPress
defaults — the two changes are independent.

### For LLMs
- **Do not raise steps 30–60 again without checking every section.** They
  are calibrated against the approved layout: 50 is the chapter-rule to
  heading gap, 60 is the chapter's vertical padding. Changing them moves
  every section on the page at once.
- Step `80` exists for one declaration (`.about__prose`). If nothing else
  ever uses it, that is fine — it is cheaper than a magic number in
  `style.css`, and it keeps the "spacing lives in theme.json" rule intact.
- `defaultSpacingSizes: false` must stay. Without it WordPress merges its
  own scale in and wins every slug collision, which is what made the token
  layer inert for the whole first half of this build.
