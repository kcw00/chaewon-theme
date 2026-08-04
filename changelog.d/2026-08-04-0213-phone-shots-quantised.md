## 2026-08-04 02:13 — Phone shots quantised to fit the upload limit

Branch: `update`, merged to `main`.

### Context
Uploading the theme zip through wp-admin on the live site failed with:

    The uploaded file exceeds the upload_max_filesize directive in php.ini.

The zip was 2,305,786 bytes against PHP's stock `upload_max_filesize`
of 2M (2,097,152) — over by 209KB, about 10%. The three phone
screenshots were 1.02MB of that.

### Changed
`assets/img/projects/*.png` re-encoded as 8-bit palette PNGs.

The naive pass (`Image.quantize` on RGBA, FASTOCTREE) cut 83% but
produced two palette entries differing only in alpha, so 287,013 pixels
of `discord-bot-phone.png` came back at alpha 254 instead of 255 —
invisible at 0.4%, but the file would no longer be honestly opaque.
Quantising RGB and re-attaching the alpha channel fixed that and saved
only 79KB, not enough.

What shipped: quantise colour to **255** entries, reserve index 255 for
the corner mask, and let transparency ride in the PNG `tRNS` chunk. The
mask is binary, which is exactly what a palette can express, so the
alpha comes back **bit-exact** (levels `[0, 255]`, byte-for-byte equal
to the source).

```
smart-diagnosis-phone.png  460.0K → 176.2K  (61.7% off)
minion-phone.png           327.9K → 133.0K  (59.4% off)
discord-bot-phone.png      258.6K → 100.3K  (61.2% off)
zip                       2,305,786 → 1,660,615 bytes
```

### Verification
```
alpha        bit-exact on all three (levels [0,255], equal to source)
error        mean 0.20–0.24/255 · <0.41% of pixels off by >8
             (better than the RGBA octree pass at 0.49–2.57)
rendered     796x1642 / 556x1206 load, complete, 304px on the page
zip          1,660,615 bytes · 426K under the 2M limit · 95 files · integrity OK
```
Compared side by side at the 304px the images actually render at:
indistinguishable. No console errors.

### Rollback
`git revert` this commit restores the full-weight PNGs — and puts the
zip back over the upload limit.

### For LLMs
- **The images are now palette PNGs with `tRNS` transparency, not
  RGBA.** Re-saving one through a tool that flattens to RGBA will
  roughly triple its size and can push the zip back over 2M. If a phone
  shot is ever re-cropped, re-run the same quantise step: 255 colours,
  index 255 reserved, `transparency=255` on save.
- Mean error is *lower* than the simpler RGBA quantiser because
  MEDIANCUT allocates the palette on colour alone instead of spending
  entries on alpha variants. Fewer colours, used better.
- The 2M ceiling is PHP's default, not a WordPress setting. Raising
  `upload_max_filesize` **and** `post_max_size` on the server is the
  other fix, and the better one long-term — the memories photos are
  still 1.0MB and the next asset added could cross the line again. A
  git-based deploy sidesteps the limit entirely.
