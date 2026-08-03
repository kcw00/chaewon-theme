# Chaewon — a custom WordPress block theme

Built from scratch. No page builder, no parent theme.

## Install

1. Zip the folder: `zip -r chaewon-theme.zip chaewon-theme`
2. WP admin → Appearance → Themes → Add New → Upload Theme
3. Activate.

Or drop the folder straight into `wp-content/themes/` if you have shell
or SFTP access — faster while developing.

## What each file does

| Path | Role |
|---|---|
| `style.css` | Theme header (required — WP reads the comment block to identify the theme) plus hand-written CSS for things theme.json can't express: transitions, keyframes, pseudo-elements. |
| `theme.json` | Design tokens. Colors, type scale, spacing. WP turns these into CSS custom properties AND into the options shown in the editor sidebar. This is the most important file. |
| `functions.php` | Enqueues style.css and reveal.js, loads editor styles, registers a block style. Block themes need very little PHP. |
| `templates/*.html` | Full page templates in block markup. `index.html` is the only required one. |
| `parts/*.html` | Header and footer, reused across templates. |
| `patterns/*.php` | Reusable block chunks, insertable from the editor. |
| `assets/js/reveal.js` | IntersectionObserver scroll reveal. Progressive — content is never hidden if JS fails. |

## The template hierarchy

WordPress picks a template by specificity, most specific first:

    front-page.html   → the site's front page
    single.html       → a single post
    page.html         → a single page
    index.html        → fallback for everything (required)

Add `archive.html`, `404.html`, `search.html` as you need them.

## Using the animation classes

In the editor, select a block → Block sidebar → Advanced →
Additional CSS class(es):

- `reveal` — fades and slides up when scrolled into view
- `reveal-stagger` — children animate in sequence
- `skills-grid` — icons lift on hover
- `project-card` — top rule that tints on hover
- `section-eyebrow` — small mono label with a trailing rule

## Fonts

`theme.json` references `assets/fonts/InstrumentSerif-Regular.woff2`,
which is not included. Either download it from Google Fonts and drop it
in, or remove the `fontFace` block and the display family falls back to
Georgia. Self-hosting is better: no third-party request, no CLS.

## Development notes

- Asset versions use `filemtime()`, so saving a file busts the browser
  cache automatically. No hard-refresh needed.
- Edit templates as files in your editor, OR in the Site Editor. If you
  edit in the Site Editor, WordPress saves an override to the database
  and your file is ignored from then on. To go back to the file:
  Appearance → Editor → Templates → the template → Reset.
- Keep the theme in git. That's the whole point.
