## 2026-08-04 00:53 — AlphaBooking, a "My part" section, and one wrong chip

Branch: `update`. **Content only — no theme files changed.** Everything
here lives in the WordPress database.

### Context
Three changes to project content.

"Production Booking Platform" was a category, not a name. It read like
the placeholder it was. The product is called AlphaBooking, and a named
product signals something that shipped.

The story was three paragraphs where two would do. The middle paragraph
listed vendor grievances — no multi-service bookings, no notes, no group
bookings, reviews trapped in the vendor's app — that chapter 02 then
answered one by one in the feature bullets. The reader did the same lap
twice. The story prose is set in mono since `efa8207`, and mono at that
length is tiring to read.

The story also said "we built them their own platform" and never said
which part was hers. It is a team project, so "we" is honest, but a
portfolio page that stops there leaves a recruiter unable to tell
whether she wrote the Django, the React, or took notes in the meetings.

On Minion, `hatchling` was listed under LANGUAGE. It is a Python build
backend.

### Changed
Applied with a one-off PHP script through `wp-load.php` and
`wp_update_post()` rather than raw SQL, so revisions, the post cache,
and the slug history behave normally. The script asserted post titles
and chapter-rule counts before writing and would `exit` on a mismatch.

**Minion (post 24)** — `hatchling` removed from the Language stack
group. Left with Python 3.11 and Node 20. Removed by verbatim block
match, not a regex over the whole document.

**AlphaBooking (post 23)**

| Field | Was | Now |
|---|---|---|
| `post_title` | Production Booking Platform | AlphaBooking |
| `post_name` | production-booking-platform | alphabooking |
| `tagline` meta | The platform they were paying too much for, rebuilt. | Production booking platform. |

The tagline is sentence case with a terminal period because all nine
other project taglines are ("The loop around a five-minute change,
automated.", "A cluster I built to host one site."). Title case there
would have been the only one.

Story cut from three paragraphs to two. The vendor-grievance paragraph
is gone. The surcharge detail, which the draft also dropped, was kept in
compressed form — 30 words instead of 45 — because chapter 02 still says
"no per-booking surcharge on either side" and "either side" is
meaningless if the page never establishes there were two.

New chapter **03 My part**, five bullets: the stakeholder loop, auth and
per-employee ACLs, the polling → SSE migration and the race it exposed,
the 5-minute TTL checkout hold with row-level locking, and the internal
NL-to-SQL agent on a self-hosted LLM with its guardrails.

It sits after "What it does", not before it. A reader needs the product
in their head before a list of contributions to it means anything.
"Built with" renumbered 03 → 04. Chapters 02 and 04 were lifted from the
existing content by splitting on the chapter rule rather than retyped —
a typo there would have silently rewritten real copy.

### Verification
```
/projects/alphabooking/                200 · title AlphaBooking
                                       italic "Production booking platform."
                                       01 The story (2 paras) · 02 What it does
                                       03 My part (5 bullets) · 04 Built with
/projects/production-booking-platform/ 301 → /projects/alphabooking/
/projects/minion/                      200 · "hatchling" in page text: false
                                       Language chips: Python 3.11, Node 20
/projects/                             AlphaBooking present, old title absent
                                       card href → /projects/alphabooking/
/                                       AlphaBooking present
```
No console errors. Database dumped to
`.context/backups/wordpress-pre-alphabooking-2026-08-04.sql` (1.6 MB)
before the first write.

### Rollback
Restore that dump. There is no code to revert — this commit is the
fragment only. Reverting by hand means renaming post 23 back, restoring
its slug, and deleting the "My part" chapter.

### For LLMs
- **The old URL redirects with a 301**, from WordPress's built-in
  `wp_old_slug_redirect`, not from anything configured here. That
  conflicts with the standing "always use 302" rule, and 301s are cached
  hard by browsers. It is harmless in this case because the site has
  never been deployed, so no client has ever seen the old URL. If the
  slug changes again after the site is public, filter
  `old_slug_redirect_url` or handle it at the proxy instead of letting
  WordPress issue the 301.
- **"My part" only exists on this project.** Four of the ten projects
  are team projects (AlphaBooking, AI Telecom, Smart Diagnosis, YVR
  Traffic). The other three still say nothing about individual
  contribution. If that section is worth having here it is probably
  worth having there, and the numbering shift applies the same way.
- The story still says "we". That is deliberate and correct — the
  section below it now carries the attribution.
- `project_tech` on the archive cards is a taxonomy; the grouped chips
  on a single project page are plain paragraphs inside `.stack-group`
  blocks in post content. They are separate data. Fixing a wrong chip on
  a detail page does not touch the card, and vice versa.
