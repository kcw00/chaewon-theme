# Chaewon — a WordPress block theme, from scratch

The theme behind my engineering portfolio. Full-site editing, no parent
theme, no page builder, no CSS framework, no build step: design tokens in
`theme.json`, one stylesheet, one `functions.php`, one small script, and
templates that are plain HTML. Edit a file, reload the browser.

The constraint that shaped everything: **use the platform.** Anything
expressible as a design token lives in `theme.json`, where WordPress turns it
into CSS custom properties *and* into the controls shown in the editor. Dark
mode is one redefinition of those properties. Content sections are block
patterns, editable in the Site Editor without touching code. And the page is
complete with JavaScript switched off — every script is an enhancement.

## Design system

### Type

Three families, self-hosted woff2, 84 KB total:

| Family | Slug | Role |
|---|---|---|
| Instrument Serif | `display` | Headings |
| Cardo italic | `lead` | Taglines, section leads, quotes — the site's italic voice |
| JetBrains Mono | `mono` | Everything else: body, buttons, links, metadata |

**There is no sans.** `mono` is the site default, so new content inherits it
with no work. Mono at a sans's size reads optically larger, and at a sans's
leading reads as a code block — so the body size is `0.9375rem` and the root
line-height is `1.8`. Those two numbers are a pair; neither moves without the
other.

### Color

Seven palette slugs, defined once in `theme.json`:

| Slug | Light | Dark | Role |
|---|---|---|---|
| `paper` | `#FDF6ED` | `#14120F` | page background |
| `ink` | `#14161A` | `#F2EBE0` | headings, strongest text |
| `ink-soft` | `#3A4049` | `#C9BFB0` | long-form prose |
| `muted` | `#6B7280` | `#9A9187` | metadata, secondary text |
| `rule` | `#E3E3DE` | `#2C2721` | hairlines, borders |
| `signal` | `#2F6F5E` | `#7FB79E` | accent, links, focus |
| `surface` | `#F2F2EE` | `#1D1A16` | raised cards |

The three text colours are a deliberate ladder — `ink` for headings,
`ink-soft` for prose, `muted` for metadata — with `ink-soft` sitting at the
L\* midpoint of the other two in both schemes. Every pair clears WCAG AA
against its background.

## Engineering notes

### Dark mode without dark rules

`theme.json` emits the palette as `--wp--preset--color--*` custom properties
on `:root`. `html[data-theme="dark"]` in `style.css` redefines those same
properties, so every block that references a palette slug — including core
blocks the theme never touches — flips automatically. There are no per-block
dark styles.

The selector is `html[data-theme="dark"]`, not a bare attribute selector, on
purpose: its specificity (0,1,1) beats `:root`'s (0,1,0), so it wins whether
the theme stylesheet loads before or after the inline global styles WordPress
prints in `<head>`.

A blocking inline script in `<head>` sets the attribute before first paint —
stored preference first, OS preference as the fallback — so the page never
flashes the wrong scheme, and someone whose system is dark gets dark on their
first visit without touching the toggle.

### Motion that fails safe

Animation is opt-in per block via a CSS class (`reveal`, `reveal-stagger`)
applied in the editor. Every hiding rule is scoped under `.js-reveal-ready`,
a class the script adds to `<html>` only once it is actually running — if
JavaScript never loads, nothing was ever hidden. `prefers-reduced-motion:
reduce` switches all of it off.

### Projects are a post type, not pages

Projects need an archive at `/projects/` and a shared single template, so
they are a custom post type with two taxonomies — `project_type` is the card
eyebrow, `project_tech` the chips — and meta fields read through block
bindings, so a tagline stays a field instead of becoming typed prose.

Where stored fields run out, a custom binding source computes: the visit
button wants a label built from the post title ("Visit Home Cluster") and a
URL that comes back as `null` — not an empty string — when the field is
blank, so the button disappears instead of linking nowhere.

Registering a post type does not create its URLs; the rewrite rules are
cached in the database. A flush keyed to `CHAEWON_REWRITE_VERSION` runs
exactly once per URL-shape change instead of on every request.

### One card, many sizes

The work section is a bento grid: some cards large, some small. A query loop
emits identical markup for every post, so the sizes come from `nth-child` on
the `<li>` wrappers the loop produces — positional CSS — rather than a
modifier class that would have to be maintained per card in the editor.

### Cache busting that survives a CDN

Asset versions are the theme version and the file's mtime, joined. In
development the mtime busts the browser cache on every save — no watcher, no
hard refresh. In production, where an optimiser or CDN may rewrite the
version to something static, the theme version still moves on every release,
so the URL still moves and the cache cannot hold a stale stylesheet.

## Anatomy

| Path | Role |
|---|---|
| `theme.json` | Design tokens: palette, type scale, spacing, block defaults. The most important file here. |
| `style.css` | The required theme header, plus everything tokens cannot express: dark scheme, layout, pseudo-elements, transitions. |
| `functions.php` | Asset loading, scheme bootstrap, skip link, the `project` post type, block bindings, block styles. |
| `templates/*.html` | Page shells, plain block markup. |
| `parts/*.html` | Header and footer, shared by every template. |
| `patterns/*.php` | The editable content sections. |
| `assets/js/site.js` | Scheme toggle, scroll reveal, rail progress, header state. |
| `assets/fonts/` | Self-hosted woff2 — see the README there. |
| `changelog.d/` | One append-only fragment per change, so concurrent branches never collide on a shared CHANGELOG. |

### The homepage

`templates/front-page.html` is six pattern references and nothing else:

```
chaewon/hero               full-viewport opening screen
chaewon/section-about      01 — long-form prose, journey line
chaewon/section-work       02 — bento grid of project cards
chaewon/section-notes      03 — query loop over posts
chaewon/section-memories   04 — masonry board
chaewon/section-contact    05 — centred closer
```

Each is a separate file in `patterns/`, so copy can be edited in the Site
Editor without touching code, and reordering the page is reordering six
lines.

### Templates

WordPress picks the most specific match:

```
front-page.html          the homepage
home.html                the notes index
archive-project.html     /projects/
single-project.html      /projects/<slug>/
single.html              a single note
page.html                a plain page
index.html               fallback (the only one WordPress requires)
```

## Utility classes

Applied from the editor under Block → Advanced → Additional CSS class(es):

| Class | Effect |
|---|---|
| `reveal` | Fades and slides up on scroll into view |
| `reveal-stagger` | Children animate in sequence |
| `label` | Mono, tracked, uppercase — for metadata |
| `label--dot` | Adds a signal-coloured dot in front |
| `label--chip` | Boxes it as a tag |
| `link-arrow` | Trailing arrow that slides on hover |

## Running it

Drop the folder into `wp-content/themes/` and activate. The directory
**must** be named `chaewon-theme` — WordPress resolves themes by directory
name, and `Text Domain:` in `style.css` has to match it.

Local development runs against a plain Docker stack (`wordpress` +
`mariadb`) with the theme bind-mounted into `wp-content/themes`. There is
nothing to install and nothing to compile.

Contributor notes — the Docker topology, permalink caveats, Site Editor
gotchas — live in [`CLAUDE.md`](CLAUDE.md).

## License

GPL-2.0-or-later. Bundled fonts are SIL OFL 1.1 — see
[`assets/fonts/OFL.txt`](assets/fonts/OFL.txt).
