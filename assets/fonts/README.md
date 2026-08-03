# Fonts

Self-hosted, latin subset, `woff2`. 132 KB total.

| File | Family | Slug | Used for |
|---|---|---|---|
| `InstrumentSerif-Regular.woff2` | Instrument Serif 400 | `display` | Headings, About prose, contact address |
| `Inter-Variable.woff2` | Inter wght 400–600 | `body` | Body copy |
| `JetBrainsMono-Variable.woff2` | JetBrains Mono wght 400–500 | `mono` | Labels, metadata |
| `Cardo-Regular.woff2` | Cardo 400 | `lead` | — |
| `Cardo-Italic.woff2` | Cardo 400 italic | `lead` | Hero tagline, section leads, card taglines, memory notes, contact eyebrow, quotes |

`lead` is the italic voice of the whole site. In practice only the italic
face is used; the roman is bundled so the family is complete and the
browser never has to synthesise an upright from the italic.

**Instrument Serif is bundled roman only.** Nothing on the page italicises
it any more — that job moved to Cardo. If a heading is ever set to italic
in the editor, the browser will synthesise a slant, which looks wrong. Add
the italic face back if that becomes a real need.

Self-hosted rather than linked from a CDN for three reasons: no third-party
request on every page load, no layout shift while a remote stylesheet resolves,
and the site renders correctly with no network (which is how it is developed,
inside Docker).

Registered in `theme.json` under `settings.typography.fontFamilies[].fontFace`.
WordPress emits the `@font-face` rules; do not hand-write them in `style.css`.

Inter and JetBrains Mono are variable. One file covers the whole weight range,
which is why there is no separate Medium or SemiBold file.

## Replacing a font

Drop the new `woff2` here, then update the matching `fontFace` entry in
`theme.json`. Both the `src` path and `fontWeight` must match the file, or the
browser silently falls back to the next family in the stack and the change looks
like it did nothing.

## Licenses

All three families are licensed under the SIL Open Font License 1.1, which
permits bundling and redistribution. See `OFL.txt`.

- Instrument Serif — Rodrigo Fuenzalida, Jordan Egstad
- Inter — Rasmus Andersson
- JetBrains Mono — JetBrains s.r.o.
- Cardo — David J. Perry
