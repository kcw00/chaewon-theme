## 2026-08-04 01:47 — Email links copy to the clipboard as a fallback

Branch: `update`.

### Context
Reported as "the send-email button and the email icon are not working."
They were not broken: all three `mailto:` links had correct hrefs,
nothing overlaid them (hit-tested at three points each), `pointer-events`
was `auto`, and no JS intercepted the click.

`mailto:` is handed to the OS, which needs a **registered mail client**
to do anything with it. On a machine where none is configured — anyone
reading webmail in a browser tab — the click is swallowed in silence:
no error, no tab, no feedback. That is the worst possible outcome for
the one control on the site whose entire job is "contact me."

### Changed
**`assets/js/site.js`** — `initEmailCopy()`, the sixth enhancement.
Copies the address on every `mailto:` click and marks the link
`data-copied` for two seconds. It never calls `preventDefault`, so a
visitor **with** a mail client still gets their compose window exactly
as before; a visitor without one now has the address on their clipboard
instead of nothing. Bails out entirely when `navigator.clipboard` is
absent (no API, or an insecure origin), leaving the links as authored.
`aria-label` carries the confirmation for screen readers, since a
visual-only badge is silent.

**`style.css`** — the `Copied` badge, a pseudo-element on the anchor so
it costs no markup and cannot reflow the label. Placement is per
context because no single side is free on all three:

| Link | Side | Why |
|---|---|---|
| `.contact__address a` | right | prose above, button below |
| `Send an email` button | below | clear space to the section rule |
| footer mail icon | above | last row on the page |

Under 560px the address drops its badge — both stacked gaps there are
12–16px and a 22px badge cannot sit in either. Acceptable because this
only bites where `mailto:` fails, and `mailto:` does not fail on a
phone: iOS and Android both ship a registered handler. The copy still
happens. The button and footer icon keep their badge at every width.

### Verification
Clipboard writes are permission-denied in headless Chromium, which
exercised the **failure** path: rejection handled, no badge, no console
error. The success path was then driven against a stubbed
`navigator.clipboard`:

```
address     copied=true badge="Copied" aria="…copied to clipboard"
button      copied=true badge="Copied" aria="…copied to clipboard"
footer icon copied=true badge="Copied" aria="…copied to clipboard"
clipboard receives the bare address, ?subject= stripped
auto-reset  data-copied and aria-label both cleared after 2s
```

Screenshotted in light and dark (badge flips ink/paper with the scheme)
and at 390px. No console errors. `node --check` clean.

### Rollback
`git revert` this commit. The `mailto:` hrefs in
`patterns/section-contact.php` and `parts/footer.html` were never
touched, so reverting returns to plain `mailto:` behaviour.

### For LLMs
- **The hrefs are not the mechanism here.** Anyone "fixing" these links
  by swapping `mailto:` for a Gmail compose URL would break every
  visitor who does not use Gmail — they would land on a Google login.
  The `mailto:` is correct and deliberate; the JS is the fallback.
- The badge needs `position: relative` on the anchor, which is set
  unscoped on `a[href^="mailto:"]`. A new mailto link anywhere in the
  theme picks up the whole behaviour with no extra work.
- Clipboard writes require a **secure context**. `localhost` counts, and
  so does the production site over HTTPS — but a plain-HTTP production
  host would silently disable the fallback and put the bug back. Verify
  the badge on the real domain after deploying.
