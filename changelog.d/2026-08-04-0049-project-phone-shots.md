## 2026-08-04 00:49 — Phone shots on three project pages

Branch: `update`.

### Context
Three screenshots supplied for the project pages — the Smart Doctor
Figma prototype for Smart Diagnosis, a task thread for Minion, and the
#pullrequests channel for Discord Bot. The requested layout follows the
reference the screenshots came with: content on the left, a phone
floating in the right-hand gutter beside the 02 and 03 sections.

### Changed
**`assets/img/projects/*-phone.png`** — three new theme assets:
`smart-diagnosis-phone.png` (800×1640), `minion-phone.png` and
`discord-bot-phone.png` (556×1206). Each source screenshot was cropped
to the device automatically — bounding box of pixels brighter than the
near-black backdrop — and the frame's corner rounding was measured from
the crop and baked into the PNG alpha, so no CSS has to guess a
per-image border-radius. Theme assets rather than media-library
attachments, same reasoning as the memories photos: they travel with
the repository.

**`style.css`** — `.project__phone`: the figure floats right on
desktop (`min(19rem, 26vw)`), drops into the flow centred under 900px.
The shadow is a `drop-shadow()` filter because it follows the PNG's
alpha; a box-shadow would paint the clipped corners back in.
`.project__body` gains `display: flow-root` to contain the float on
short projects. `.stack-group` swaps the constrained layout's auto
centring for explicit percentage margins — see For LLMs.

**Content (database, not git)** — the three posts each gain one
`core/image` block with `align:right` and className `project__phone`,
inserted immediately before the 02 chapter rule. `align:right` matters:
constrained layout excludes `.alignright` from its
`margin-inline: auto !important` child rule, which is what lets the
figure float at all.

### Verification
Screenshots at 1440px (light and dark) and 390px, all three pages:

```
minion            phone right of 02+03, hairlines stop at it,
                  all five stack rows share one left edge
discord-bot       phone right of 02, ends before 03
smart-diagnosis   phone right of 02+03, flow-root holds it off the rule
390px             figure leaves the float, centred between 01 and 02
dark              phones keep contrast; shadow deepens to /0.55
```

No console errors. Assets serve 200 from
`/wp-content/themes/chaewon-theme/assets/img/projects/`. Database
dumped to `.context/backups/wordpress-pre-phone-shots-*.sql` before the
post edits.

### Rollback
`git revert` this commit for CSS and assets. Content is separate:
restore the backup dump, or remove the image block from each of the
three posts in wp-admin.

### For LLMs
- **The stack-group margin change is load-bearing for the float.** A
  grid is a formatting-context root, so one that centres with auto
  margins re-centres in the space left of a float — stack rows beside
  the phone sat further left than rows below it (visible on Minion,
  whose phone ends mid-stack). Percentage margins resolve against the
  container and ignore floats, so every row keeps one left edge. The
  `!important` is required; the layout engine's auto pair is
  `!important` too.
- The phone images are cropped to the device with transparent corners.
  Any effect added around them must respect alpha
  (`filter: drop-shadow`, not `box-shadow`; no `background` on the img).
- wp-cli is not installed in the WordPress container. The working
  pattern is a one-off container on the compose network:
  `docker run --rm -i --network chaewon-wp_default --volumes-from
  chaewon-wp-wp-1 --user 33:33 -e WORDPRESS_DB_HOST=db -e
  WORDPRESS_DB_USER=wp -e WORDPRESS_DB_PASSWORD=wp -e
  WORDPRESS_DB_NAME=wordpress wordpress:cli wp …` — and `wp post update
  <id> -` reads content from stdin, since the container cannot see host
  paths.
- Only these three projects have a `project__phone` figure. The other
  seven render exactly as before; the section is opt-in per post, like
  the authored `03 Built with`.
