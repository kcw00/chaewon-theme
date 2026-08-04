## 2026-08-04 02:35 — Paragraph rhythm for single posts

Branch: `update`.

### Context
The first published note (`/build-notes-giving-an-llm-read-only-keys-to-a-production-database/`)
read as a wall of text. Two independent causes:

1. **Spacing.** `single.html` rendered `post-content` with no class, so
   paragraphs got the root `blockGap` of 0.75rem — 12px. At the site's
   1.8 leading a line is 27px, so the space *inside* a paragraph was
   more than twice the space *between* two, and paragraphs stopped
   reading as paragraphs. Headings were the same 12px, so a section
   break looked like a paragraph break.
2. **Stray `<br>`.** The note's markdown is hard-wrapped at ~80
   characters and was pasted into the editor, which preserved every
   source line-ending as a literal line break — 4 in the first
   paragraph, 5 in the fourth. Not fixed by CSS; see below.

### Changed
**`templates/single.html`** — `post-content` gains
`className="note__body prose"`, `post-title` gains `note__title`.
`prose` brings the link treatment the rest of the site uses.

**`style.css`** — a Note body section:

| Rule | Value | Why |
|---|---|---|
| `> * + *` | `1.8em` | one full line — the oldest rule in body copy, and the one 12px violated |
| `> h2` | `spacing--70` (56px) | must beat the paragraph gap to read as a break |
| `> h3` | `spacing--60` (36px) | subdivides rather than separates |
| `> :is(h2,h3,h4) + *` | `spacing--40` (16px) | a heading owns what follows it |
| code / quote / table | `spacing--50` block | these carry their own padding; air goes around the box |
| `li + li` | `0.9em` | half the paragraph gap — separates without reading as paragraphs |
| `.note__title` | `spacing--20` top, 0 bottom | 12px under display-serif at heading scale read as a caption gap |
| `.note__body` | `spacing--60` top | separates the masthead from the body |

### Verification
Rendered locally against a real converted copy of the note:
```
paragraph gap   27px = 1 line (was 12px)
h2 top          56px · paragraph after h2 16px
quote / code    24px · rendered with their theme.json styling
title → body    36px (was 12px)
stray <br>      0
smart quotes    curly ✓
```
No console errors.

### Rollback
`git revert` this commit. The template and CSS are the whole change; no
content is touched.

### For LLMs
- **`blockGap` was not raised, and should not be.** It is 0.75rem
  site-wide and also drives flex and grid gaps in the header, contact
  actions, and stack groups. The paragraph problem is scoped to
  long-form bodies, so the fix is scoped there too.
- `.project__body` still runs at the 12px gap and has the same
  tightness. It was left alone deliberately — an earlier instruction in
  this series was to stop applying project-page changes site-wide. Ask
  before extending `note__body`'s rhythm to it.
- **Pasting hard-wrapped markdown into the block editor produces
  `<br>` at every source line-ending.** CSS cannot fix that. Content
  has to be converted with wrapped lines re-joined into single
  paragraphs. Do not `html.escape` quotes when generating that markup —
  `&quot;`/`&#x27;` survive `wptexturize` untouched and you lose smart
  quotes; escape `&<>` only.
