# Fonts

Self-hosted, latin subset, `woff2`. 108 KB total.

| File | Family | Axes |
|---|---|---|
| `InstrumentSerif-Regular.woff2` | Instrument Serif | 400 |
| `InstrumentSerif-Italic.woff2` | Instrument Serif | 400 italic |
| `Inter-Variable.woff2` | Inter | wght 400–600 |
| `JetBrainsMono-Variable.woff2` | JetBrains Mono | wght 400–500 |

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
