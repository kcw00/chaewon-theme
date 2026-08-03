## 2026-08-03 19:24 — About: drop the journey line, centre the prose, use the body face

### Context
Three requests against the About section:

1. Remove the Seoul-to-Vancouver journey diagram and the hairline above it.
2. Move the body content into the middle of the column.
3. Set the body copy in the same font as the project card copy.

### Changed
**`patterns/section-about.php`** — removed the `wp:html` journey block.
Pattern description updated; it still advertised the journey line.

**`style.css`**
- Deleted 106 lines: the whole `.journey*` block including its stacked
  mobile media query. Nothing referenced it any more.
- `.about__prose > p`:
  - Dropped the `font-family` declaration entirely. Inter is the inherited
    default, so the prose is now the same face as `.work-card__body`,
    one size up.
  - `max-width` 82ch → 58ch. Inter's zero is wider than Instrument
    Serif's, so the same `ch` value would have rendered a much longer
    line. 58ch lands at 805px, close to the previous 830px.
  - `line-height` 1.65 → 1.6.
  - Added `margin-inline: auto` to centre the block.

### Verification
`http://localhost:8080`, no console errors.

```
journeyEl        false
prose family     Inter        card family  Inter    identical: true
prose size       22px         card size    17px
width            805px        leftGap 188  rightGap 188   centred: true
mobile 390px     prose 369px, leftGap 0, no horizontal overflow
```

Text stays flush left inside the centred block; only the block is centred.

Confirmed in both schemes. `php -l` clean, CSS comment nesting and brace
balance script-checked.

### Rollback
`git revert` this commit. The journey markup and CSS both come back.

### For LLMs
- **The browser cached a stale render and made this change look like it had
  failed.** A screenshot after `goto` still showed the removed journey line
  while `curl` of the same URL and the file inside the container both
  showed it gone. `filemtime()` versioning busts the CSS and JS cache but
  does nothing for the HTML document. When verifying a markup change, load
  with a cache-buster (`?nc=$(date +%s)`) before trusting a screenshot, and
  cross-check with `curl` — the server response is the ground truth.
- `ch` is font-relative. Changing a family without re-tuning a `ch`
  max-width silently changes the measure. Inter's zero is materially wider
  than Instrument Serif's.
- The prose block is centred while its text is left-aligned. Do not add
  `text-align: center` — centred ragged-right text over four lines is
  measurably harder to read, and the request was to move the block.
- The heading and lead are still flush left at the column edge while the
  prose is centred. That asymmetry is the literal result of the request;
  if it should change, centring `.chapter-title` and `.chapter-lead` in
  this section is the follow-up.
