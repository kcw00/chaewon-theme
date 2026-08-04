## 2026-08-04 02:08 — Visit buttons made visible with a placeholder URL

Branch: `update`. **Content only — the fragment is the whole diff.**

### Context
The Visit button on a project page is hidden when `project_url` is
empty: the binding returns `null`, the anchor renders with no `href`,
and `.project__visit:has(a:not([href]))` removes it. No project had the
meta set, so the button had never appeared on any of the ten pages.

Asked to make the buttons visible now, with the real links to be filled
in through wp-admin later.

### Changed
`project_url` set to `https://github.com/kcw00` on all ten projects
(IDs 23–32) via wp-cli. No code changed — the button was always coded
to appear as soon as the meta has a value.

The GitHub profile was chosen over `#` or a guessed repo URL because it
is a real page that cannot 404. **It is still a placeholder and is
wrong on every project**: the button reads "Visit Minion" and goes to a
profile.

### Verification
```
minion           display=flex  "Visit Minion"           href set  visible
discord-bot      display=flex  "Visit Discord Bot"      href set  visible
smart-diagnosis  display=flex  "Visit Smart Diagnosis"  href set  visible
alphabooking     display=flex  "Visit AlphaBooking"     href set  visible
```
No console errors.

The wp-admin edit path was checked before setting anything, so the
"fill in later" plan is known to work:
```
is_protected_meta('project_url','post')        false   → shows in the box
post_type_supports('project','custom-fields')  true    → box is available
registered with show_in_rest                   true
```
To edit: open a project → Options (⋮) → Preferences → Panels → enable
**Custom fields** → Enable & Reload. The `project_url` row is then
editable at the bottom of the editor.

### Rollback
Content only:
`.context/backups/wordpress-pre-project-urls-20260804-020600.sql`, or
clear the field on each project to hide the buttons again.

### For LLMs
- **All ten URLs are placeholders pointing at a profile page.** They
  must be replaced before the site is public, or every project page
  ships a button that misdescribes where it goes. Finding them is easy:
  they are the only ten posts whose `project_url` is exactly
  `https://github.com/kcw00`.
- Clearing `project_url` is the supported way to hide the button again;
  the hide path is CSS on a missing `href`, not a template condition.
- These values live in the database, so they do **not** travel with the
  theme and are **not** in `chaewon-projects.xml` (exported before this
  change). A fresh import on the live site starts with empty
  `project_url` and hidden buttons again.
