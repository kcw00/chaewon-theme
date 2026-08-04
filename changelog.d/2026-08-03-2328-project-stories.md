## 2026-08-03 23:28 — Real project stories and structured stacks

Branch: `update`.

### Context
Written stories supplied for six projects — Booking Platform, Minion, AI
Telecom, Discord Bot, PawBondAI, AI Chat — each with a multi-paragraph
narrative, a what-it-does list, and a stack grouped by concern.

The grouped stacks were the reason for a structural change. A real stack
has shape: backend, frontend, delivery, observability. The `03 Built
with` section was generated from the `project_tech` taxonomy, which can
only produce a flat row of chips, and a flat row throws that shape away.

### Changed
**`templates/single-project.html`** — the `03 Built with` block removed.
The section is now authored per project in the post body.

**`style.css`** — `.stack-group`: a two-track grid, mono category label
left and prose right, hairline between rows, collapsing to one column
under 700px.

**Content**
- Six projects: story, what-it-does, and grouped stack rewritten as
  supplied. Taglines and card excerpts rewritten to match the new
  narratives.
- Four projects with no written story — Portfolio Website, Smart
  Diagnosis, YVR Traffic, C++ SDL2 Games — had a `03 Built with`
  backfilled from their existing terms, so all ten pages keep the same
  three-part structure.

The taxonomy still drives the compact chips on cards, which is the job it
is good at.

### Verification
All ten project pages, each showing four chapter rules (year/type, 01,
02, 03):

```
production-booking-platform            paras 3  bullets  8  stack 4
minion                                 paras 3  bullets  6  stack 5
ai-telecom-customer-service-platform   paras 3  bullets 11  stack 6
discord-bot                            paras 3  bullets 10  stack 8
portfolio-website                      paras 1  bullets  4  stack 3
pawbondai                              paras 3  bullets  9  stack 5
ai-chat-app                            paras 3  bullets  9  stack 3
smart-diagnosis                        paras 1  bullets  3  stack 2
yvr-traffic                            paras 1  bullets  2  stack 2
c-sdl2-games                           paras 1  bullets  3  stack 3
```

Card taglines and excerpts updated on the archive. Stack grid 176px +
455px on desktop, single column at 390px with no horizontal overflow.
Dark scheme: label `rgb(154,145,135)`, items `rgb(201,191,176)`.
No console errors.

### Rollback
`git revert` this commit for the template and CSS. Content is separate —
restore from `.context/backups/` or re-edit under Projects in wp-admin.

### For LLMs
- **`03 Built with` lives in the post body, not the template.** Every
  project page is expected to carry it; a new project without one will
  render 01 and 02 and then stop. If a template-level section is ever
  reintroduced it will collide with the authored ones.
- The `project_tech` taxonomy is now only used for card chips. It is
  deliberately not the source for the stack section — a taxonomy cannot
  express grouping, and grouping is the whole point of that section.
- `.stack-group` is a grid inside `.project__body`, which sets
  `max-width` on its direct `p`, `ul`, and `ol` children. The group's
  children reset `max-width: none`, or the right-hand column would be
  constrained twice.
- The four backfilled stacks were written from existing taxonomy terms,
  not from source. They are accurate at the level the terms were, and
  are the first thing to replace when those projects get real write-ups.
