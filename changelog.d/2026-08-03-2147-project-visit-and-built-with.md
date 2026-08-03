## 2026-08-03 21:47 — Project page: visit link, 03 Built with, chips relocated

### Context
Three requests on the single project page: a "Visit {name} →" link beside
the title, an `03 — BUILT WITH` chapter rule, and the tech chips moved
out of the footer to sit under that rule.

### Changed
**`functions.php`**
- `project_url` post meta, `show_in_rest`.
- `chaewon/project` block binding source with two keys:
  - `url` — the meta, or **null** when blank.
  - `visit_label` — `Visit {post title}`.

**`templates/single-project.html`**
- Title and tagline wrapped in `.project__intro-text`, with the visit
  button beside them in `.project__intro`.
- New `.project__built` group: the `03 / Built with` chapter rule
  followed by the `project_tech` terms.
- Chips removed from the footer, which is now just "All projects →".

**`style.css`**
- `.project__intro` flex row, items aligned to the tagline's baseline.
- `.project__visit` strips core/button back to a text link with an arrow,
  and hides the whole wrapper when the anchor has no href.
- `.project__built` spacing.

**Content** — `project_url` set on the five real projects. Deliberately
left blank on `telecom-analytics`, `reading-list`, and `deploy-bot` to
exercise the hide path.

### Why a custom binding source
`core/post-meta` hands a block a stored value verbatim, which does not
cover either requirement here.

The label has to contain the project's own title, which is not stored
anywhere as a string. And the URL has to come back as `null` rather than
`''` when unset — an empty string still renders an anchor, and
`<a href="">` points at the current page, so a project with no link would
show a live-looking "Visit X" that reloads the page. Returning null means
the anchor renders with no `href` at all, which the CSS can then detect.

`core/button` is used rather than a paragraph because it is the only core
block whose `url` attribute is bindable.

### Verification
```
with a URL      text "Visit Home Cluster" · href https://github.com/kcw00
                wrapper display: block
without a URL   anchor href null · wrapper display: none
chapter rules   2026 Infrastructure · 01 The story · 02 What it does · 03 Built with
chips           Docker · k3s · Nginx, inside .project__built
footer          0 term blocks remaining
dark            visit rgb(127,183,158) · chips rgb(154,145,135)
mobile 390px    visit wraps below the title block · no horizontal overflow
```
No console errors.

### Rollback
`git revert` this commit. The `project_url` values stay in the database
harmlessly; delete them under each project if wanted.

### For LLMs
- **`core/button` is the only core block whose `url` can be bound.** If a
  bound link is needed, that is the block, and the button chrome gets
  styled away.
- **A binding that returns `''` still renders the block.** Return `null`
  when a field is unset so the markup is detectably empty — here the
  anchor ends up with no `href`, and
  `.project__visit:has(a:not([href]))` removes it. Returning an empty
  string would ship a link to the current page.
- The `03` rule lives in the **template**, not the post body, because the
  chips come from the `project_tech` taxonomy rather than from anything
  typed. `01` and `02` are authored per project. Adding a `04` to a
  project body will therefore collide with nothing, but a second
  template-level section would need renumbering here.
- `.project__intro` aligns on `flex-end` so the visit link sits on the
  tagline's baseline. It wraps below the title block under ~24rem, which
  is why `.project__intro-text` has `flex: 1 1 24rem`.
