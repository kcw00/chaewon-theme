## 2026-08-04 02:52 — Asset versions survive the CDN

Branch: `update`. Theme version 0.2.0 → **0.3.0**.

### Context
A theme upload landed on production and the site kept rendering the
previous stylesheet: note titles still 112px, paragraph gaps still 12px,
32 stray `<br>` still in the post. The classes were in the HTML and the
rules were in the file on disk, so the deploy had worked.

The evidence, gathered from the live site:

```
live  <link id='chaewon-style-css'  …/style.css?ver=0.2.0
local <link id='chaewon-style-css'  …/style.css?ver=1785811356
live  <script id='chaewon-site-js'  …/site.js?ver=1785811398
```

Same handle, same code, and the **script** got its mtime while the
**stylesheet** got the theme version. Something in front of the origin —
CDN, optimiser, or host page cache — rewrites stylesheet versions to the
theme version. `0.2.0` had not changed since the first upload, so the URL
had not changed, so Cloudflare answered every request from cache:

```
GET style.css?ver=0.2.0   cf-cache-status: HIT   age: 2095
                          75,618 bytes · last-modified 02:15 · 0 note__ rules
GET style.css (no query)  cf-cache-status: MISS
                          79,105 bytes · last-modified 02:43 · rules present
```

The origin was correct the whole time. Only the URL the browser asks for
was frozen.

### Changed
**`style.css`** — `Version: 0.3.0`. This is now a release-critical
field, not decoration.

**`functions.php`** — asset versions are `{theme version}.{mtime}`
instead of mtime alone, via one shared helper for both files. Whatever
upstream rewrites, the theme version still moves on every release, so
the URL still moves. `filemtime()` on an unreadable file returns `false`
and emits a warning; the helper guards with `is_readable()` and falls
back to the theme version rather than emitting a versionless URL, which
would cache forever — the exact failure being fixed.

### Verification
```
local  style.css?ver=0.3.0.1785811926
       site.js?ver=0.3.0.1785807693
       title 52px · paragraph gap 27px · h2 32px   (styles still apply)
php -l functions.php                                clean
```

### Rollback
`git revert`. Versions return to bare mtime and the CDN staleness
returns with them.

### For LLMs
- **Bump `Version:` in `style.css` on every release.** It is load-bearing
  for cache busting in production, because the mtime half of the version
  is not guaranteed to survive the CDN. A release that changes CSS but
  not the version can be served stale indefinitely.
- Diagnosing this class of bug: fetch the asset **with the exact query
  string the browser uses**. Fetching `style.css` bare is a different
  cache key and will look fresh while the real request is stale. That
  false negative cost a full diagnostic pass here.
- The `?ver=0` seen in an early grep was an artifact of matching
  `ver=[0-9]+` against `0.2.0`. Match the whole value.
- A Cloudflare purge is the immediate remedy for an already-cached
  asset; the version bump is what stops it recurring.
