## 2026-08-04 00:58 — Phone up beside the story, prose flush left

Branch: `update`.

### Context
Feedback on the first phone-shot pass: the phone started at the 02
rule, so on a tall story the whole right gutter beside 01 sat empty and
the phone arrived a screen later. Requested layout: the phone's top on
the "01 — The story" rule, and the story / what-it-does / built-with
column moved to the left edge instead of centred.

### Changed
**Content (database, not git)** — the `project__phone` image block
moved from before the 02 rule to the very top of the post body on all
three posts. The float's top now lines up with the 01 rule because the
figure precedes it in flow.

**`style.css`**
- `.project__body > p/ul/ol` and `.stack-group`: `margin-inline: 0
  !important`, replacing the constrained layout's auto centring (and
  the stack-group's percentage-margin compromise from the last pass,
  which existed only to keep centred rows on one edge — moot now).
- `.project__body > .chapter-rule`: `max-width: none; margin-inline: 0
  !important` — the 01/02/03 rules follow the prose to the left edge
  and span like the year rule at the top of the article. Without this
  they centre in whatever space the float leaves and the 01 number
  lands on a different left edge than the paragraph under it.

**`assets/img/projects/*.png`** — re-cropped. The first pass kept any
column with a lit pixel, which preserved the iPhone's protruding side
buttons as bright slivers outside the rounded mask — invisible on
paper, two floating white marks on the dark scheme. The crop now drops
columns lit in fewer than 15% of rows (protrusions, not frame), taking
`smart-diagnosis-phone.png` from 801px to 796px wide. The two Discord
mockups have no protruding buttons and came out identical.

### Verification
1440px light and dark, 390px mobile, all three pages:

```
left edges     title, 01/02/03 numbers, prose, list, stack labels
               all share one edge in both schemes
phone top      on the 01 rule on all three pages
hairlines      01/02 stop at the phone; rules clear of it span full
smart-diag     no slivers left of the frame in dark
mobile         phone leads the body, centred above the 01 rule
```

No console errors.

### Rollback
`git revert` for CSS and images. Content: move the image block back
below the 02 rule in each post, or restore
`.context/backups/wordpress-pre-phone-shots-*.sql` (pre-dates both
passes).

### For LLMs
- The body's left alignment is now three `margin-inline: 0 !important`
  declarations (prose, chapter rules, stack groups). All three fight
  the same `margin-inline: auto !important` the constrained layout puts
  on every child; removing any one of them re-centres that element the
  moment the float is narrower than the leftover space.
- The figure must stay the **first block** in the post body. Anything
  authored above it pushes the float down and the top-of-01 alignment
  silently breaks.
- The 15%-of-rows column filter in the crop is what keeps device
  buttons from poking through the alpha mask. Re-cropping a new phone
  shot with a plain bounding box will reintroduce the sliver bug on
  dark.
