## 2026-08-03 08:54 — Five homepage chapters

### Context
The homepage was a hero and nothing else. This adds the five content
sections, renumbered after "The Path" (work-history timeline) was cut and
"Along the Way" was renamed "Memories".

Section 01 is "About me", not "Field Notes". Destination is Vancouver, not
Surrey. Origin (Seoul) confirmed correct.

### Changed
**New patterns**
- `patterns/section-about.php` — 01. Chapter rule, serif prose at 58ch, and
  a Seoul → Vancouver journey line. The journey diagram is `wp:html`
  rather than nested groups; it is a diagram, not prose.
- `patterns/section-work.php` — 02. Rewritten from the old scaffold into a
  four-card bento grid.
- `patterns/section-notes.php` — 03. `core/query` over the four most recent
  posts, with a `core/query-no-results` branch.
- `patterns/section-memories.php` — 04. Masonry board, four plates and two
  written notes.
- `patterns/section-contact.php` — 05. Centred closer.

**`style.css`** — sections 08 through 12 appended, plus:
- `.work-card__tags > * { margin: 0 }`.
- `.about__prose > p` measure 40ch → 58ch.

**`templates/front-page.html`** — six `wp:pattern` references, nothing else.

**`parts/header.html`** — nav is Work / Notes / Memories / Contact. Rail
destination `Surrey 49.1°N` → `Vancouver 49.3°N`.

**`patterns/hero.php`** — secondary CTA now targets `#about`.

**`README.md`** — rewritten. The old copy described the scaffold: it
referenced `assets/js/reveal.js` (deleted), `section-eyebrow` and
`project-card` (removed), and said the fonts were not included (they are).

### Verification
At 1440×900 against `http://localhost:8080`, both schemes, no console
errors.

| Check | Result |
|---|---|
| Sections present | about 784px, work 855px, notes 377px, memories 354px, contact 507px |
| Work cards | 4 |
| Memory tiles | 6 (4 plates + 2 notes) |
| Notes query | 1 post rendered, no-results branch not triggered |
| Tag chips share a top edge | `[2116, 2116, 2116]` |
| Anchor lands clear of header | `#work` top 104px vs header bottom 89px |
| Scroll reveal | 2 of 2 fire; `--scroll-progress` 0.6911 at 55% |
| Header `is-scrolled` | toggles |
| Mobile 390×844 | rail `display:none`, board 1 column, no horizontal overflow |

`php -l` clean on all six patterns and `functions.php`. CSS comment nesting
and brace balance verified by script.

### Rollback
`git revert d9ad06d` and the two follow-up fix commits. `front-page.html`
reverts to hero-only; the pattern files become unreferenced but harmless.

### For LLMs
- **An empty `core/image` block renders to nothing on the front end.** The
  memory board was originally built from empty Image blocks and silently
  collapsed from six tiles to two. Photo slots are `.memory-plate` groups
  that hold their space. Replace a plate with a real Image block when there
  is a photo; the aspect ratio lives on a modifier class.
- **WordPress's flow layout adds `margin-block-start` to every sibling after
  the first.** Inside any flex row this staircases the children. Zero the
  margins and let `gap` do the spacing. This is the second time this has
  bitten (see the hero fragment for the constrained-layout variant).
- Section groups use `"layout":{"type":"default"}`. `section-contact` is the
  deliberate exception — it uses `constrained` because it wants the auto
  margins for centring.
- `.journey__distance` sits on the connecting hairline with
  `background: paper` behind it, which is what makes the line appear to
  break around the text. It depends on the page being one flat colour.
- The content is placeholder. Copy, project names, dates, and
  `hello@example.com` all need replacing before this is shown to anyone.
