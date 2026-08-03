# Chaewon — WordPress block theme

A full-site-editing (FSE) block theme for an engineering portfolio. No parent
theme, no page builder, no build step. Edit a file, reload the browser.

## Local development

WordPress runs in Docker, separate from this repo:

    ~/chaewon-wp/docker-compose.yml     wordpress:6-php8.3-apache + mariadb:11
    ~/chaewon-wp/themes/                bind-mounted to wp-content/themes
    http://localhost:8080               the site

The theme lives at `~/chaewon-wp/themes/chaewon-theme`, which is its own clone
of this repository. Changes made in a Conductor workspace are not visible at
localhost:8080 until they land in that clone:

    git -C ~/chaewon-wp/themes/chaewon-theme fetch <workspace-path> <branch>
    git -C ~/chaewon-wp/themes/chaewon-theme checkout FETCH_HEAD

Start and stop the stack:

    cd ~/chaewon-wp && docker compose up -d
    cd ~/chaewon-wp && docker compose down          # keeps the dbdata volume

`docker compose down -v` destroys the database. Never run it without asking.

### Pretty permalinks need two container fixes

`/projects/` and every other pretty URL 404s unless all three hold:

1. Settings → Permalinks is not "Plain".
2. Apache allows `.htaccess` for the docroot. The base image ships
   `AllowOverride None`, so this theme's URLs do not work out of the box.
3. `/var/www/html/.htaccess` actually contains the WordPress rewrite
   block. WordPress writes only the BEGIN/END markers when it cannot
   detect mod_rewrite.

Items 2 and 3 were applied inside the running container and are lost on
`docker compose up --force-recreate`. To make them permanent, add to
`~/chaewon-wp/docker-compose.yml`:

    volumes:
      - ./apache-allow-override.conf:/etc/apache2/conf-enabled/wp-allow-override.conf:ro

containing:

    <Directory /var/www/html>
        AllowOverride All
    </Directory>

## The folder name is load-bearing

WordPress identifies a theme by its directory name. It must stay
`chaewon-theme`, and `Text Domain: chaewon-theme` in `style.css` must match it.
Rename either one and translations stop loading.

## Where things belong

| Concern | File |
|---|---|
| Colors, type scale, spacing, block defaults | `theme.json` |
| Dark scheme, layout, transitions, pseudo-elements | `style.css` |
| Asset loading, post types, block styles | `functions.php` |
| Page shells | `templates/*.html` |
| Header and footer | `parts/*.html` |
| Editable content sections | `patterns/*.php` |
| Behavior | `assets/js/*.js` |

## Projects

Projects are a `project` post type, not pages, because they need an
archive at `/projects/` and a shared single template.

| Piece | Where |
|---|---|
| Post type, taxonomies, `tagline` meta | `functions.php` |
| Card markup, shared by homepage and archive | `patterns/project-card.php` |
| `/projects/` | `templates/archive-project.html` |
| `/projects/<slug>/` | `templates/single-project.html` |

`project_type` is the card eyebrow, `project_tech` the chips, and
`tagline` the italic line under the title — a meta field read through a
block binding, so it stays a field rather than typed prose.

Registering a post type does **not** create its URLs. The rewrite rules
are cached in the database; without a flush `/projects/` 404s while every
line of configuration looks correct. `chaewon_maybe_flush_rewrites()`
handles this, keyed to `CHAEWON_REWRITE_VERSION` — bump that constant
whenever a URL shape changes.

Card sizes are positional. A query loop emits identical markup for every
post, so the bento comes from `nth-child` on the `<li>` wrappers that
`core/post-template` produces, not from a modifier class per card.

Anything expressible as a design token goes in `theme.json`, not `style.css`.
WordPress turns those tokens into CSS custom properties *and* into the controls
shown in the editor sidebar. Hard-coding a hex in `style.css` means it does not
appear in the editor and it will not follow the dark scheme.

## Design system

Six palette slugs, defined once in `theme.json`:

| Slug | Light | Dark | Role |
|---|---|---|---|
| `paper` | `#FDF6ED` | `#14120F` | page background |
| `ink` | `#14161A` | `#F2EBE0` | headings, strongest text |
| `ink-soft` | `#3A4049` | `#C9BFB0` | long-form prose |
| `muted` | `#6B7280` | `#9A9187` | metadata, secondary text |
| `rule` | `#E3E3DE` | `#2C2721` | hairlines, borders |
| `signal` | `#2F6F5E` | `#7FB79E` | accent, links, focus |
| `surface` | `#F2F2EE` | `#1D1A16` | raised cards |

The three text colours are a deliberate ladder: `ink` for headings,
`ink-soft` for prose, `muted` for metadata. `ink-soft` sits at the L\*
midpoint of the other two in both schemes.

All pairs clear WCAG AA against their background. Re-check with the script in
`changelog.d/` before changing a value.

Four families: `display` (Instrument Serif) for headings, `body` (Inter) for
prose, `mono` (JetBrains Mono) for metadata and labels, `lead` (Cardo italic)
for taglines, section leads, and quotes. Mono is doing real work here — it is
the visual signal for "this is data, not prose."

`lead` is the site's italic voice. Every italic on the page is Cardo; every
upright serif is Instrument Serif. Instrument Serif is bundled **roman only**,
so italicising a heading makes the browser synthesise a slant.

## Dark mode

`html[data-theme="dark"]` in `style.css` redefines the `--wp--preset--color--*`
custom properties that `theme.json` emits on `:root`. Every block that
references a palette slug flips automatically; no per-block dark rules.

The attribute selector is deliberate. `html[data-theme]` has specificity (0,1,1)
against `:root`'s (0,1,0), so it wins regardless of whether the theme stylesheet
loads before or after WordPress's inline global styles. Do not weaken it to
`[data-theme="dark"]` alone.

A blocking inline script in `<head>` (`functions.php`) sets the attribute before
first paint. Without it the page flashes light before flipping. Keep it inline
and keep it blocking.

## Motion

Every animation is opt-in via a CSS class applied in the editor under
Advanced > Additional CSS class(es):

- `reveal` — fades and slides up on scroll into view
- `reveal-stagger` — children animate in sequence

Hiding styles are scoped under `.js-reveal-ready`, which `site.js` adds to
`<html>` only after it runs. If JavaScript fails, nothing is ever hidden.

`prefers-reduced-motion: reduce` disables all of it. That block at the bottom of
`style.css` is not optional.

## Editing templates

Templates can be edited as files, or in Appearance > Editor. Editing in the Site
Editor writes an override to the database and the file is ignored from then on.
To go back to the file: Appearance > Editor > Templates > pick it > Reset.

This surprises everyone once.

## Changelog

Every change gets a new fragment under `changelog.d/`, named
`<UTC-YYYY-MM-DD-HHMM>-<kebab-slug>.md`. Generate the timestamp with:

    date -u +"%Y-%m-%d-%H%M"

Fragments are append-only. Never edit or delete an existing one. Never create
`CHANGELOG.md` — per-fragment files exist so concurrent branches stop colliding
on the same prepended lines.

## Commit style

Small and labeled. One concern per commit, Conventional Commits prefix, and a
body explaining *why* when the reason is not obvious from the diff.
