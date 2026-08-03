## 2026-08-03 21:57 — Visit link on every project card

### Context
The visit link existed only on a project's own page. Requested on the
cards too, so `/projects/` offers the outbound link without a detour
through the detail page.

### Changed
**`patterns/project-card.php`** — a `core/buttons` block after the tech
chips, bound to the same `chaewon/project` source added earlier: `url`
from the `project_url` field, `visit_label` as `Visit {post title}`.

Because the card pattern is shared, this lands on `/projects/` and the
homepage grid at once.

**`style.css`** — `.work-card__visit` styled as a small text link with an
arrow, `position: relative; z-index: 2`, and hidden when the anchor has
no href.

### Two links in one card
The card is otherwise a single hit target: the post title's `::after` is
stretched across the whole surface at `z-index: 1`. A second link inside
that needs `z-index: 2` or it is simply unreachable — the overlay eats
the click.

It also stays focusable, unlike the taxonomy links which get
`tabindex="-1"`. That difference is deliberate. The term links are an
accident of how `core/post-terms` renders and lead somewhere the card
never advertised; the visit link is a second destination the card is
explicitly offering. Two tab stops per card — the card itself to the
project page, the visit link to the project — is the correct outcome.

### Verification
```
archive     8 cards
            5 visit links shown, labelled Visit {project name}
            3 hidden — telecom-analytics, reading-list, deploy-bot have no URL
homepage    4 cards, all 4 visit links shown
hit test    point on the visit link  → A href=https://github.com/kcw00
            point elsewhere on card  → A href=…/projects/booking-platform/
            tab stops per card       → 2
hover       transform matrix(1,0,0,1,0,-8), shadow unchanged by the new link
mobile 390  5 visit links, no horizontal overflow
```
No console errors.

### Rollback
`git revert` this commit. The single project page keeps its own visit
link, which is a separate block in `templates/single-project.html`.

### For LLMs
- **A link inside a stretched-link card must out-stack the overlay.** The
  overlay is `z-index: 1`; anything meant to remain clickable inside the
  card needs a higher stacking order and its own positioning context.
  Without it the element renders normally and is silently unclickable,
  which looks like a broken href rather than a stacking problem.
- The card now has two links on purpose. Do not "fix" this by giving the
  visit link `tabindex="-1"` — that treatment belongs to the taxonomy
  links, which are not a destination the card is offering.
- The link appears on the homepage as well, because both grids share
  `patterns/project-card.php`. Scoping it to the archive means a rule on
  `.work-grid--home .work-card__visit`, not a second pattern.
