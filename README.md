# Chaewon — a custom WordPress block theme

A full-site-editing theme for an engineering portfolio. Built from scratch:
no parent theme, no page builder, no build step. Edit a file, reload the
browser.

Contributor notes, the Docker topology, and the design system live in
[`CLAUDE.md`](CLAUDE.md).

## Install

Drop the folder into `wp-content/themes/` and activate it. The directory
**must** be named `chaewon-theme` — WordPress resolves themes by directory
name, and `Text Domain:` in `style.css` has to match it.

To distribute instead:

```sh
zip -r chaewon-theme.zip chaewon-theme
```

Then Appearance → Themes → Add New → Upload Theme.

## What each file does

| Path | Role |
|---|---|
| `theme.json` | Design tokens. Colors, type scale, spacing, block defaults. WordPress turns these into CSS custom properties *and* into the controls in the editor sidebar. The most important file here. |
| `style.css` | Theme header (required — WP parses the comment block to identify the theme) plus everything `theme.json` cannot express: the dark scheme, layout, pseudo-elements, transitions, media queries. |
| `functions.php` | Asset loading, the colour-scheme bootstrap, skip link, pattern category, block styles. |
| `templates/*.html` | Page shells. `index.html` is the only one WordPress requires. |
| `parts/*.html` | Header and footer, reused across templates. |
| `patterns/*.php` | The editable content sections. |
| `assets/js/site.js` | Scheme toggle, scroll reveal, rail progress, header state. |
| `assets/fonts/` | Self-hosted woff2. See the README in that folder. |

## The homepage

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

## Editing content

**In the browser:** Appearance → Editor, or the Edit link on the front end.

**Careful:** editing a template in the Site Editor saves an override to the
database, and the file on disk is ignored from that point on. Since the
theme is version controlled, that is usually not what you want. To go back
to the file: Appearance → Editor → Templates → pick it → **Reset**.

**In files:** edit `patterns/*.php` directly. WordPress caches pattern file
headers against the theme version, so a *newly added* pattern file will not
appear until that cache clears. Bump `Version:` in `style.css`, or:

```sh
docker exec chaewon-wp-wp-1 php -r 'require "/var/www/html/wp-load.php";
  $t = wp_get_theme();
  $m = new ReflectionMethod("WP_Theme", "delete_pattern_cache");
  $m->setAccessible(true); $m->invoke($t);'
```

Editing an existing pattern needs none of this.

## Utility classes

Apply from the editor under Block → Advanced → Additional CSS class(es):

| Class | Effect |
|---|---|
| `reveal` | Fades and slides up on scroll into view |
| `reveal-stagger` | Children animate in sequence |
| `label` | Mono, tracked, uppercase — for metadata |
| `label--dot` | Adds a signal-coloured dot in front |
| `label--chip` | Boxes it as a tag |
| `link-arrow` | Trailing arrow that slides on hover |

Nothing is ever hidden unless JavaScript is running, and everything is
disabled under `prefers-reduced-motion: reduce`.

## Templates

WordPress picks the most specific match:

```
front-page.html   the site's front page
single.html       a single post
page.html         a single page
index.html        fallback for everything (required)
```

Add `archive.html`, `404.html`, or `search.html` as needed.

## Development

Asset versions use `filemtime()`, so saving a file busts the browser cache.
No hard refresh needed.

WordPress runs in Docker at `~/chaewon-wp`, separate from this repo, against
its own clone of it. See [`CLAUDE.md`](CLAUDE.md) for how to get changes from
a working copy into the running site.

## License

GPL-2.0-or-later. Bundled fonts are SIL OFL 1.1 — see
`assets/fonts/OFL.txt`.
