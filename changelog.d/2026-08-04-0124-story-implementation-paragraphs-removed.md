## 2026-08-04 01:24 — Implementation paragraphs cut from four project stories

Branch: `update`. **Content only — no files changed, nothing to merge.**

### Context
Four project stories each closed with a paragraph enumerating the
implementation (services, threads, registries, inference endpoints).
Requested removal on all four. The pattern in what was cut is
consistent: the *how it is wired* paragraph goes, the *what problem it
solves* and *what it does* paragraphs stay. That material is not lost —
`03 Built with` already lists the same tools as chips.

### Changed
Post bodies only, via wp-cli. Every story goes 3 paragraphs → 2.

| Post | ID | Removed |
|---|---|---|
| AI Telecom Customer Service Platform | 25 | "It's a monorepo of seven deployable services…" |
| AI Chat App | 29 | "Most of what I learned came after git push…" **and** the trailing sentence "That's the current scope, not something I'm hiding." from the paragraph above it |
| PawBondAI | 28 | "It's a FastAPI backend over Elasticsearch…" |
| Discord Bot | 26 | "It's one Python process running Flask…" |

The AI Chat edit is the odd one: that sentence ends a paragraph that
stays, so it was cut from inside the paragraph rather than as a block.
The paragraph now ends "…so there's no conversation memory yet."

### Verification
Read back from the rendered pages, not the database:

```
ai-telecom    2 story paras · 6 stack rows · 4 chapter rules
ai-chat-app   2 story paras · 3 stack rows · 4 chapter rules
              para 2 ends "no conversation memory yet."
pawbondai     2 story paras · 5 stack rows · 4 chapter rules
discord-bot   2 story paras · 8 stack rows · 4 chapter rules
```

No console errors. Discord Bot carries a phone shot, so the shorter
story was re-checked against the float: phone bottom y=1031, first
stack row top y=1534 — the whole 03 section is still below the float,
and all eight rows share one left edge (396px). Minion and Smart
Diagnosis re-checked too; one distinct row-left each.

### Rollback
Content only: restore
`.context/backups/wordpress-pre-story-trim-20260804-012149.sql`, or
re-add the paragraphs under Projects in wp-admin. No commit to revert.

### For LLMs
- **Shortening a story on a phone-shot page moves the float relative
  to `03 Built with`.** The stack rows centre through auto margins,
  which resolve differently beside a float than below one — see
  `2026-08-04-0112-stack-rows-centred.md`. Any future story edit on
  minion, discord-bot, or smart-diagnosis needs the same check that
  was run here: phone bottom vs first stack-row top, and one distinct
  `getBoundingClientRect().left` across the rows.
- The trim script asserted structure before writing (3 chapter-rule
  groups, balanced paragraph comments, no new blank-line runs) and
  three of those assertions were themselves wrong on the first pass —
  `class="chapter-rule"` is really `class="wp-block-group
  chapter-rule"`, the stack-group markup legitimately contains `\n\n\n`
  runs, and paragraph openers come in two forms (`<!-- wp:paragraph
  -->` and `<!-- wp:paragraph {…} -->`). Worth knowing before writing
  another block-markup validator.
