## 2026-08-03 22:29 — Visit link back to project pages only; chips display-only

### Context
Three corrections:

1. The visit link should live on a project's own page, not on every card.
2. On the project page it should sit higher — between the title and the
   tagline rather than on the tagline's baseline.
3. The skill chips should not be clickable.

### Changed
**`patterns/project-card.php`** — the `core/buttons` visit block removed.

**`style.css`**
- Deleted the 53-line `.work-card__visit` block. Nothing references it.
- `.project__intro` `align-items: flex-end` → `center`.
- The term-link demotion now covers `.project .wp-block-post-terms a` as
  well as `.work-card …`.

**`assets/js/site.js`** — `initCardTerms()` selector widened to project
pages, so chips there lose their tab stop too.

### Why the chips were links at all
`core/post-terms` always renders a term as a link to its taxonomy
archive. This theme has no `archive.html` and no taxonomy template, so
every chip pointed at a page that would fall through to `index.html` and
render as an undesigned list. On a card they were also a second hit
target inside a surface that is already one link.

They are now inert in both senses — `pointer-events: none` for the mouse,
`tabindex="-1"` for the keyboard — but deliberately still in the
accessibility tree, because the project type and the stack are content
worth announcing.

### Verification
```
archive     8 cards · 0 visit links · 26 chips, all pointer-events none
            0 chips focusable · 1 tab stop per card
homepage    4 cards · 0 visit links · 0 chips focusable · 1 tab stop each
            hover still matrix(1,0,0,1,0,-8) with the shadow bloom
project     4 chips, pointer-events none, 0 focusable
            elementFromPoint on a chip → DIV.taxonomy-project_tech,
            not the anchor — genuinely unclickable
            visit link present with its href
            title bottom 260 · visit midpoint 262 · tagline top 268
            → the link now lands on the seam between the two lines
mobile 390  visit link wraps below the title block · no horizontal overflow
```
No console errors.

### Rollback
`git revert` this commit. That restores the card visit link, which also
restores a second tab stop per card.

### For LLMs
- **A card is one hit target again.** One tab stop, one destination. If
  something ever needs to be clickable inside a card, it has to clear the
  stretched overlay at `z-index: 1` — and that is a decision to make
  deliberately, not a side effect of adding a block.
- `core/post-terms` cannot be told not to link. Demoting it takes both
  halves: `pointer-events: none` in CSS and `tabindex="-1"` in JS. Adding
  a taxonomy display anywhere new needs both, and the selector lists in
  section 09 of `style.css` and `initCardTerms()` are where they live.
- If taxonomy archives are ever wanted, this is the constraint to undo
  first — and they would need a template before the chips are re-enabled.
