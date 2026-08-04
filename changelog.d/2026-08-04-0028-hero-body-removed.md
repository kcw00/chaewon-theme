## 2026-08-04 00:28 — Hero loses its body paragraph and divider

Branch: `update`.

### Context
The hero said the same thing three times. The tagline reads "Software
engineer — I build the systems I run, and run the systems I build." The
paragraph under it restated that at length. Chapter 01 then said it a
third time, properly, in three paragraphs of real prose.

The copy was also overclaiming. "Deployments, monitoring, the 3am page"
and "most of what I know came from breaking something in production and
having to explain why" is the voice of someone with years of on-call
behind a company incident-review process. About, 400px below, says she
is looking for her first full-time team. A reader who catches that
mismatch discounts the rest of the page.

The alternative considered and rejected was replacing the prose with a
mono status strip (`STATUS / BASED / CURRENTLY`), which would have
surfaced the availability line that is currently buried in paragraph
three of Chapter 01. Worth revisiting if the fold needs to work harder
for recruiters; it was declined here in favour of a quieter hero.

### Changed
**`patterns/hero.php`** — removed the `core/paragraph` with class
`hero__body` and the `core/separator` with class `hero__divider`. The
hero is now name → tagline → actions → scroll cue.

The separator went with the paragraph rather than staying behind. It
existed to breathe between the tagline and the body; with the body gone
it is a 3rem rule between a line of italic and a button, which reads as
decoration rather than structure.

**`style.css`** — deleted the `.hero__body` and `.hero__divider` rules.
The gap they used to provide moves onto `.hero__tagline`'s bottom
margin, `spacing--60` (2.25rem).

That value is deliberate: `.hero__name`'s bottom margin is `spacing--30`
(0.75rem), so the tagline now sits three times closer to the name than
the buttons sit to the tagline. Name and tagline read as one unit, the
actions as a second. `spacing--50` (1.5rem) was tried first and sat too
close to 0.75rem to register as a break.

The margin goes on the tagline, not on `.hero__actions`, because every
other hero child already owns its own bottom margin. Keeping that
convention means the vertical rhythm is readable in one place instead of
split between a bottom margin here and a top margin there.

### Verification
Fetched into `~/chaewon-wp/themes/chaewon-theme` and loaded
`localhost:8080` at 1440x900.

```
light    paragraph gone · rule gone · name → tagline → buttons
dark     toggle sets data-theme=dark · same layout · signal on Kim flips
mobile   375x812 · tagline wraps to 3 lines · buttons clear · cue visible
DOM      document.querySelectorAll('.hero__body, .hero__divider') → 0
computed .hero__tagline margin-bottom → 36px (2.25rem)
console  no errors
```

### Rollback
`git revert 3ff3029`. Nothing else references either class — both were
hero-only, confirmed by grep across `*.php`, `*.html`, `*.css`, `*.js`
before deleting.

### For LLMs
- **The hero has no prose slot any more.** Anything that wants to be a
  sentence on the homepage belongs in Chapter 01, not the fold. If a
  future change needs the fold to carry information, the mono data strip
  described under Context is the shape to reach for — it matches the
  page's existing "mono means data, not prose" rule and the coordinate
  rail already establishes that voice at the same scroll position.
- `.hero__tagline`'s bottom margin is now load-bearing for the whole
  gap between the title block and the buttons. Setting it back to `0`
  collides the two, because `.hero__actions` has no top margin and the
  group is flow layout.
- The tagline copy itself is unchanged and still predates the current
  About section. The earlier note in
  `2026-08-03-2300-real-content.md` flagged this; it is still open.
