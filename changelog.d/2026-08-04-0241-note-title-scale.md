## 2026-08-04 02:41 — Note titles and headings step down a scale

Branch: `update`.

### Context
A published note's title rendered at 7rem and ran to four lines and
426px — the reader met a wall of serif before a word of the note.

The `h1` element style is `display` (7rem) with 0.95 leading and
negative tracking. That is correct for the page it was designed
around: a project title is a *name*, "Minion" fills one line and
stops. A note title is a *sentence*, and the same size is wrong for it.

### Changed
**`.note__title`** — `xx-large` (3.25rem), leading 1.1, tracking
`normal`. 0.95 is set for one or two lines of big type and collides on
three; negative tracking is a display-size correction and at this size
it only tightens the words. 426px → 114px, four lines → two.

**`.note__body` headings step down one preset each.** Dropping the
title to `xx-large` put it at exactly the size of an untouched `h2` —
section headings the same size as the title of the piece containing
them. Inside a note body: `h2` → `x-large`, `h3` → `large`, `h4` →
`medium` in the tracked uppercase muted style the theme uses for
labels.

Resulting scale: title 52px › h2 32px › h3 22px › body 15px.

### Verification
```
title    52px · 114px tall · 2 lines   (was 112px · 426px · 4 lines)
h2       32px, one line                (was 52px, two)
hierarchy title > h2 > h3 > body, distinct at every step
```
No console errors.

### Rollback
`git revert` this commit; titles return to the global `h1` scale.

### For LLMs
- **The heading step-down is not cosmetic — it is what keeps the
  hierarchy.** If `.note__title` is ever moved back up to `display`,
  remove the `.note__body` heading overrides with it, or notes end up
  with a 7rem title over 2rem headings and a broken middle.
- Project pages are untouched. `.project__title` stays at `display`
  because a project title is one or two words; it is not the same
  problem.
