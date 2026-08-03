## 2026-08-03 22:09 — Nav destinations work off the homepage

### Context
From a project page, clicking Notes produced
`/projects/this-theme/#notes` and went nowhere. A bare fragment resolves
against the current document, so `#notes`, `#memories`, and `#contact`
only ever worked on the homepage — the one page where those sections
exist. Every other page silently appended a dead anchor.

Notes also needed to point at `/writing/` now that the posts archive
exists.

### Changed
`parts/header.html`:

| Item | Before | After |
|---|---|---|
| Work | `/projects/` | unchanged |
| Notes | `#notes` | `/writing/` |
| Memories | `#memories` | `/#memories` |
| Contact | `#contact` | `/#contact` |

### Why root-relative rather than absolute
`/#memories` keeps the homepage behaviour intact. The path already
matches when you are on `/`, so the browser treats it as a same-document
fragment navigation — no reload, and `scroll-behavior: smooth` still
applies. From anywhere else the same href navigates home and lands on the
section. One value covers both cases; a full `http://…/#memories` would
force a reload even on the homepage.

### Verification
Nav destinations from every page type:

```
/                       Work:/projects/  Notes:/writing/  Memories:/#memories  Contact:/#contact
/writing/               same
/projects/              same
/projects/this-theme/   same
/hello-world/           same
```

From a project page, following Memories lands at section top 112px with
the header bottom at 68px — clear, and `scroll-padding-top` held.

From a clean homepage URL, clicking Memories is an in-page jump: a
JavaScript marker set before the click survived it, so no reload
occurred, and the section still landed at 112px.

### Rollback
`git revert` this commit.

### For LLMs
- **Never use a bare `#fragment` in `parts/header.html` or
  `parts/footer.html`.** They render on every template, and a fragment
  resolves against whatever page the visitor is on. Homepage sections
  must be linked as `/#section`.
- The in-page-versus-reload distinction depends on the **whole URL**
  matching except the fragment. Testing this with a `?cache-buster` in
  the address produces a false "it reloads" result, because the query
  string makes it a different URL. Load the bare path when verifying
  fragment behaviour.
- `footer.html` still has a placeholder `url:"#"` on the LinkedIn social
  link. It is inert rather than wrong, but it is the last bare fragment
  in a site-wide part and should get a real URL.
