## 2026-08-04 01:34 — Discord Bot: 02 trimmed to what the bot does

Branch: `update`. **Content only — the fragment is the whole diff.**

### Context
`02 What it does` had grown to ten bullets, and the last five described
how the bot is built, shipped, and watched rather than what it does for
the team. Every tool those five named is already a chip in `03 Built
with`: Jenkins, flake8, pytest, Harbor, Keel, Prometheus, Grafana,
Application Insights, KQL, GCP Compute Engine, Azure VMs. The section
was re-stating the stack list in sentence form.

### Changed
Post 26 body only, via wp-cli. Ten bullets → five.

Removed:
- "Pushes events, custom metrics, and exceptions to Azure Application
  Insights for KQL log analysis"
- "/health reports Discord gateway state…" (absorbed, see below)
- "CI gates on lint → pytest → container smoke test…"
- "Keel polls Harbor every 30s and rolls the Deployment…"
- "Prometheus + Grafana stack deployable to GCP and Azure VMs…"

Rewritten — the `/metrics` bullet ended in a six-item enumeration
(counts by event, action, status, auth failures, duration histogram,
gateway latency, guild count) and now reads:

    Exposes /metrics for Prometheus and /health for Kubernetes probes

One line instead of two, and it keeps the instrumentation claim, which
is on-theme: this project's eyebrow is literally "Observability".

Kept: the three event bullets (PR opened, build failed, recovered) —
which are the tagline, "The alarm, and the all-clear after it" — plus
the HMAC signature-verification bullet, a decision about how the bot
behaves rather than a tool name.

### Verification
Read back from the rendered page:

```
5 bullets, in order:
  PR opened/approved · build failure · recovered notice ·
  HMAC rejection · /metrics + /health
4 chapter rules · 8 stack rows · one distinct row left (396px)
```
No console errors.

### Rollback
Content only: restore
`.context/backups/wordpress-pre-bullet-trim-20260804-013308.sql`, or
re-add the bullets in wp-admin. No commit to revert.

### For LLMs
- **This page is now close to the float threshold.** Phone bottom
  y=1031, first stack row top y=1150 — a 119px gap where it was 503px
  before this trim. The 03 rows centre through auto margins, which
  resolve differently beside a float than below one (see
  `2026-08-04-0112-stack-rows-centred.md`), so removing roughly two
  more lines from 01 or 02 would put the first stack row alongside the
  phone and stagger it against the rows below. Re-check
  phone-bottom vs first-row-top after any further cut here.
- The same ten-bullet pattern — real behaviour first, pipeline and
  deploy plumbing last — exists on other projects. `ai-telecom` (11
  bullets) and `pawbondai` (9) are the next candidates if this
  treatment is wanted site-wide; they were left alone deliberately,
  this change was scoped to Discord Bot.
