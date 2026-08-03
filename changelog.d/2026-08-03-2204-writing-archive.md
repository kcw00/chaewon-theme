## 2026-08-03 22:04 — Writing archive at /writing/

### Context
"Browse all writing →" pointed at `/blog`, which did not exist and 404'd.
Requested: a page listing every post with a thumbnail, in the style of
the reference blog index.

### Changed
**`templates/home.html`** — new. WordPress uses this template for the
page assigned as the posts page. Chapter rule, h1, lead, then a query
loop of 10 per page with pagination and an empty state.

Each row is a two-track grid: a 15rem thumbnail on the left, and title,
excerpt, and date on the right.

**`style.css`** — section 14. Row layout, thumbnail plate, hover, focus
ring, reduced-motion, and a single-column fallback under 700px where the
thumbnail becomes 16/9.

**`patterns/section-notes.php`** — "Browse all writing" now points at
`/writing/`.

**Content** — created a page "Writing" and set it as
Settings → Reading → Posts page. That is what gives the template a URL;
without it `home.html` is never used.

### The thumbnail wrapper exists for a reason
`core/post-featured-image` renders **nothing at all** — not an empty
figure, no markup — when a post has no featured image. Dropping it
straight into the grid would collapse that row to a single track while
every other row had two, so the list would jump around depending on which
posts happened to have images.

The block is wrapped in `.writing-row__media`, which always renders and
holds the column. It carries the dashed placeholder styling, and
`:has(img)` switches the border to transparent once a real image is
present so the placeholder outline does not frame the photo.

### Verification
Confirmed the image path end to end by generating a temporary attachment,
checking it, and deleting it again — otherwise the first real thumbnail
would have been the first test.

```
/writing/       HTTP 200 · h1 "Notes & writing" · lead correct
grid            240px + 924px tracks
with an image   object-fit cover · plate 240x180 · img 238x178
                (the 2px is the 1px border either side — exact fill)
                border switches dashed -> transparent
without one     plate holds its column, dashed placeholder
hit target      thumbnail, title, date all resolve to A
                a point above the row resolves to P — overlay is cropped
hover           border rgba(34,32,28,.42) · title rgb(47,111,94)
                image matrix(1.05, 0, 0, 1.05, 0, 0)
dark            border rgba(242,235,224,.42) · title rgb(127,183,158)
mobile 390px    single column, media 16/9, no horizontal overflow
media library   0 attachments after cleanup
```
No console errors.

### Rollback
`git revert` this commit, then unset Settings → Reading → Posts page and
delete the Writing page. The template becomes unused rather than broken
if only the code is reverted.

### For LLMs
- **`home.html` only renders if a page is assigned as the posts page.**
  The template alone does nothing; `page_for_posts` is what gives it a
  URL. If `/writing/` ever 404s or shows the page's own empty content,
  check that option first.
- **`core/post-featured-image` outputs nothing when there is no
  thumbnail**, so it cannot be a grid track on its own. Wrap it in an
  element that always renders if the column has to hold its width.
- The row uses the same oversized-and-cropped overlay as the notes list
  (`inset: -100vh -100vw` plus `overflow: hidden` on the row). Here there
  is no transformed ancestor, so `inset: 0` would also work — it is
  written this way to stay consistent, and to survive someone later
  adding a transform to the row.
- The nav's Notes item still points at `#notes` on the homepage rather
  than at `/writing/`. That was not part of the request; changing it is a
  one-line edit in `parts/header.html`.
