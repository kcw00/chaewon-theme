## 2026-08-04 00:32 — Correction: the mono swap is spread across four commits

Branch: `update`. **This fragment corrects
`2026-08-04-0031-mono-everywhere.md`, which is wrong about where the
changes live.** Fragments are append-only, so it is corrected here
rather than edited.

### Context
Two agents were working in this checkout at the same time, on the same
branch, and both committed with `git add -A`. Each one's commit swept up
the other's in-flight edits. No work was lost and the final tree is
correct, but the commit messages do not describe their own contents.

### What actually landed where

```
3ff3029  style(hero): drop the body paragraph and its divider
         patterns/hero.php, style.css, theme.json
         ALSO CONTAINS: deletion of the `body` (Inter) font family
                        from theme.json

7f57b43  docs: changelog fragment for the hero body removal
         changelog.d/2026-08-04-0028-hero-body-removed.md
         ALSO CONTAINS: assets/fonts/Inter-Variable.woff2 deletion,
                        assets/fonts/README.md, style.css,
                        theme.json  -- i.e. most of the mono swap

a8784c5  style: mono everywhere, Inter removed
         CLAUDE.md, assets/fonts/README.md
         Only this. The commit message describes work that had already
         been committed under 7f57b43 a few seconds earlier.

5f8f065  docs: changelog fragment for the mono swap
         the fragment only
```

### The correction
`2026-08-04-0031-mono-everywhere.md` says "`git revert` this commit …
restores the font file, the family, the preset sizes, and the docs
together." **That is false.** Reverting `a8784c5` restores two doc
files and nothing else.

To actually undo the mono swap, revert `7f57b43` and `3ff3029` — and
note that doing so also restores the hero body paragraph, which was a
separate, deliberate change by the other agent.

### Verification
The tree is correct regardless of how the commits are labelled. At
`5f8f065`, working tree clean:

```
theme.json   families [display, mono, lead]
             root fontFamily = mono, lineHeight 1.8, letterSpacing 0
             medium 0.9375rem (fluid 0.875–0.9375)
             elements.button fontFamily = mono
grep         no --wp--preset--font-family--body anywhere
HTTP         Inter-Variable.woff2 -> 404
rendered     /                  Mono 73  Instrument Serif 17  Cardo 10
             /projects/minion/  Mono 66  Instrument Serif  1  Cardo  1
             Inter: 0 on every page
console      no errors
```

### Rollback
Nothing to roll back — this fragment is a record, not a change.

### For LLMs
- **This checkout can have more than one agent in it.** Before
  committing, run `git status` and confirm every staged path is one you
  touched. `git add -A` in a shared tree captures someone else's work
  and mislabels it. Prefer `git add <explicit paths>`.
- History was deliberately **not** rewritten. The commits are shared and
  another agent was mid-task; a rebase would have corrupted its state.
  Mislabelled history that is documented beats rewritten history that
  surprises someone.
- When tracing when a change landed, `git log --follow <file>` or
  `git log -S<string>` is reliable here; commit subjects are not.
