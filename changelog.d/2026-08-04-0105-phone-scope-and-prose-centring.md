## 2026-08-04 01:05 — Phone layout scoped to its pages, prose centred in the gap

Branch: `update`.

### Context
Two corrections to the flush-left pass. First, the left alignment was
meant only for the three pages that carry a phone shot; it had leaked
to all ten project pages. Second, on the phone pages the prose was not
meant to hug the left edge — it should sit in the middle of the space
between the article's left edge (where the 01 number starts) and the
left side of the phone. The 03 section stays flush left as it was.

### Changed
**`style.css`** — every rule from the flush-left pass is now scoped
with `.project__body:has(.project__phone)`: the `flow-root`, the
full-width left-edge chapter rules, and the stack-group zero margins.
The seven projects without a phone shot render exactly as they did
before any of this — centred body, content-size chapter rules.

On phone pages the prose picks up an explicit centring margin instead
of zero:

    margin-inline: max(0px, calc((100% - min(19rem, 26vw)
      - var(--wp--preset--spacing--50) - 60ch) / 2)) auto !important;

Container width minus the float's outer width minus the 60ch column,
halved — the midpoint of the gap. It cannot be an auto margin because
auto centres on the container and ignores the float. Applied at
≥900px only; below that there is no float and the body falls back to
the constrained layout's own centring.

### Verification
1440px screenshots:

```
minion           prose centred between the 01 edge and the phone,
                 03 rows still on the left edge, rules unchanged
smart-diagnosis  same
pawbondai        (no phone) byte-for-byte the pre-phone layout:
                 centred prose, centred content-size chapter rules
```

No console errors.

### Rollback
`git revert` this commit. No content changes in this pass.

### For LLMs
- `:has()` is the scoping mechanism, so the phone image block in the
  post body is what turns the whole layout on. Deleting the figure
  from a post reverts that page to the centred layout with no CSS
  edit — and adding a figure to a fourth project opts it in.
- The centring calc duplicates the float's width expression
  (`min(19rem, 26vw)` + `--wp--preset--spacing--50`). If the figure's
  width or margin changes, the calc must change with it or the prose
  drifts off-centre.
- The `max(0px, …)` matters between 900px and roughly 1080px, where
  the gap is narrower than 60ch and the raw calc goes negative.
