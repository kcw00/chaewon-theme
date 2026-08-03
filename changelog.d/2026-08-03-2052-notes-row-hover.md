## 2026-08-03 20:52 — Hover interaction on the note rows

### Context
Each row in Notes & writing was static. Requested: an arrow affordance, a
content shift with the year lighting up, a darkening hairline, sibling
dimming across the list, and the whole row as one hit target.

### Changed
**`patterns/section-notes.php`**
- Title and excerpt wrapped in `.notes-row__body`.
- `wp:html` arrow span per row, `aria-hidden="true"`.

**`style.css`**
- Row grid `9rem 1fr` → `9rem 1fr auto`; the third track holds the arrow.
- Hairline moved from `border-top` on every row to `border-bottom`, with
  a `border-top` on `:first-child` so the list is still closed at both
  ends. Visually identical; `border-bottom-color` is the animated
  property.
- Resting: date at 42% opacity, arrow at `opacity: 0`,
  `translateX(-6px)`, accent green.
- Hover and `:has(… a:focus-visible)`: body `translateX(10px)` over
  `.36s cubic-bezier(.2,.7,.3,1)`, date to full opacity in accent green
  over `.3s`, `border-bottom-color` to `rgb(34 32 28 / .42)` over `.34s`,
  arrow to `opacity: 1` / `translateX(0)` over `.3s`.
- Sibling dimming: `.notes-list:hover .wp-block-post { opacity: .45 }`
  with the hovered row back to 1, `.28s ease`.
- Focus ring on the row; the inline link's own outline suppressed.
- Dark-scheme counterpart for the hairline literal.
- `prefers-reduced-motion`: translates and dimming dropped, colours kept.

### The overlay that escaped its row
The row is one hit target via a stretched `::after` on the title link,
the same approach as the project cards. `inset: 0` did not work here.

`.notes-row__body` translates on hover, and a transformed element becomes
the containing block for its absolutely-positioned descendants. So the
overlay sized itself against the body group instead of the row: the year
column was never clickable, and the overlay slid 10px along with the
content.

Fixed by oversizing the overlay past every edge (`inset: -100vh -100vw`)
and adding `overflow: hidden` to the row to crop it. That gives exact row
coverage in both states with no arithmetic against the grid tracks. The
row's own outline is unaffected by its own overflow, so the focus ring
still shows.

### Verification
No console errors. Tested with a second row cloned into the DOM
client-side, since the site has only one published post.

```
hit target   year / title / excerpt / far right / top and bottom padding → A
             above the row → P.chapter-lead   page mid → SECTION
             (overlay confined to its own row)

hovered      opacity 1 · border rgba(34,32,28,.42)
             body matrix(1,0,0,1,10,0) · date 1 rgb(47,111,94)
             arrow 1 matrix(1,0,0,1,0,0)
sibling      opacity 0.45 · everything else at rest

focus        focus-visible true · ring 2px solid rgb(47,111,94) offset 4px
             link outline none · same shift, arrow and colour as hover

layout       offsetTop/Width/Height unchanged on hover, list height delta 0

reduced      body transform none · arrow transform none · sibling opacity 1
             border rgba(34,32,28,.42) and date rgb(47,111,94) kept

dark         border rgba(242,235,224,.42) · date rgb(127,183,158)
```

### Rollback
`git revert` the two commits. Rows return to static two-column layout.

### For LLMs
- **A stretched `::after` cannot use `inset: 0` when any ancestor between
  it and the target is transformed.** `.notes-row__body` translates, so it
  becomes the containing block. The oversize-and-crop pattern here is
  deliberate; `overflow: hidden` on `.notes-list .wp-block-post` is load
  bearing and removing it lets the overlay swallow clicks across the page.
- Sibling dimming needs two or more published posts to be visible. With
  one row, hovering the list and hovering the row are the same thing.
- The hairline literal `rgb(34 32 28 / .42)` is tuned for the cream page
  and is near-invisible on the dark scheme, hence the paired
  `html[data-theme="dark"]` rule. Changing one means changing both.
- The row grid drops to `1fr auto` under 700px with the arrow spanning
  both rows, so it stays a column beside the stacked year and content
  rather than becoming a third line.
