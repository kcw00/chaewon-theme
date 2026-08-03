## 2026-08-03 21:35 — Projects: post type, archive, and detail pages

### Context
Work cards were static markup that linked nowhere. Requested: each card
opens a detail page, and the Work nav item opens an archive of every
project with the heading "Things I've built", the sub-heading "Projects
I've been building", and eight varied-size cards in a centred column.

### Changed
**`functions.php`**
- `project` post type. `has_archive: 'projects'`, rewrite slug
  `projects`, `show_in_rest` so the block editor and block bindings work.
- `project_type` taxonomy (hierarchical, one term) — the card eyebrow.
- `project_tech` taxonomy (flat) — the chips.
- `tagline` post meta with `show_in_rest`, read through a block binding
  rather than typed into a block, so it stays a field.
- `chaewon_maybe_flush_rewrites()` on `init` priority 20, keyed to
  `CHAEWON_REWRITE_VERSION`, plus a flush on `after_switch_theme`.

**New files**
- `templates/archive-project.html` — chapter rule, h1, lead, query of 8,
  pagination, empty state.
- `templates/single-project.html` — back link, chapter rule built from
  the post date and type, title, bound tagline, post content, tech chips.
- `patterns/project-card.php` — the card, shared by the homepage grid and
  the archive so they cannot drift. `Inserter: no`, because outside a
  loop it renders empty.

**`patterns/section-work.php`** — rewritten as a query of the four most
recent projects. The hand-written copy moved into the seeded posts
verbatim.

**`parts/header.html`** — Work now points at `/projects/`.

**`style.css`** — section 13. Archive grid cycles eight footprints via
`nth-child`; homepage bento is positional on `.work-grid--home`; single
project layout; `.chapter--first` reserves the header height.

**`assets/js/site.js`** — `initCardTerms()` drops taxonomy links inside
cards out of the tab order.

**Content** — 8 projects seeded. The first four carry the previous
homepage copy exactly; four are labelled placeholders.

### The environment, not the theme
`/projects/` returned 404 with everything configured correctly. Three
separate causes, in order:

1. **Permalinks were plain** (`?p=123`). Set to `/%postname%/`.
2. **`AllowOverride None`** on `/var/www/` in `apache2.conf`, so Apache
   ignored `.htaccess` entirely. Added
   `/etc/apache2/conf-available/wp-allow-override.conf` and enabled it.
3. **`.htaccess` was empty** — WordPress had written the BEGIN/END
   markers with no rules, because it could not detect mod_rewrite from
   the CLI. Written by hand.

**Only the first survives a container rebuild.** Items 2 and 3 live
inside the running container. See "For LLMs" for the permanent fix.

### Verification
```
URLs        /  /projects/  /projects/booking-platform/  /hello-world/   all 200
archive     8 cards · h1 "Things I've built" · lead "Projects I've been building."
            spans 4,2,2,4,3,3,2,4 across a 6-column grid
homepage    4 cards, spans 4/2rows · 2/2rows · 2 · 4
            links /projects/{booking-platform,noteapp,noteapp-minion,home-cluster}/
single      title, bound tagline, back link, 3 chapter rules, 3 chips
            content 5 paragraphs, 3 list items
header      rule top 128 vs pill bottom 68 — clear
hover/focus transform matrix(1,0,0,1,0,-8) · shadow rgba(30,25,20,.28) 0 20px 36px -16px
            arrow matrix(1,0,0,1,5,-5) · ring 2px rgb(47,111,94)
hit target  card centre, tag area, eyebrow all resolve to A
term links  0 focusable
responsive  800px span 3 · 390px span 6 · no horizontal overflow
```
No console errors. Database dumped to `.context/backups/` before the
permalink change and the seed.

### Rollback
`git revert` the feature commits. Content and settings are separate:
delete the 8 projects under Projects in wp-admin, and set Settings →
Permalinks back to Plain if wanted. The Apache conf disappears on
container rebuild by itself.

### For LLMs
- **Registering a post type does not create its URLs.** Rewrite rules are
  cached in `wp_options`. Without a flush, `/projects/` 404s while every
  line of configuration reads correctly. The flush is keyed to
  `CHAEWON_REWRITE_VERSION`; bump it when URL shapes change.
- **This container needs two things pretty permalinks normally get for
  free.** `AllowOverride All` for the docroot, and a non-empty
  `.htaccess`. Both were applied inside the running container and will be
  lost on `docker compose up --force-recreate`. The permanent fix is a
  bind mount in `~/chaewon-wp/docker-compose.yml`:

  ```yaml
  volumes:
    - ./apache-allow-override.conf:/etc/apache2/conf-enabled/wp-allow-override.conf:ro
  ```

  with that file containing
  `<Directory /var/www/html>\n  AllowOverride All\n</Directory>`.
  A backup of the compose file is in `.context/backups/`.
- **A query loop emits identical markup per post**, so bento layouts have
  to be positional. `.work-grid--home` uses `nth-child(1..4)`;
  `.work-grid--archive` cycles `8n+1..8n+8` with `grid-auto-flow: dense`
  so a short card backfills the hole a two-row card leaves.
- **The grid children are the `<li>` wrappers `core/post-template`
  emits**, not the cards. Size the `<li>`; the card stretches inside it.
- `core/post-title` renders a plain `<a>` with no theme class. The card's
  stretched overlay targets `.work-card__title a` for that reason —
  the earlier `.work-card__link` selector matched nothing once the cards
  became dynamic, and hover, focus, and the hit target all silently died.
- `core/post-terms` always renders links. Inside a card that is already
  one hit target they are demoted with `pointer-events: none` and
  `tabindex="-1"`, but deliberately not `aria-hidden` — the type and the
  stack are content.
- **Reading a computed transform immediately after `.focus()` or a hover
  returns the pre-transition value.** This produced two false "the lift
  is broken" diagnoses in one session. Sleep ~1s before measuring.
