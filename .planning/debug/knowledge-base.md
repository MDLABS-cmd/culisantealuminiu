# GSD Debug Knowledge Base

Resolved debug sessions. Used by `gsd-debugger` to surface known-pattern hypotheses at the start of new investigations.

---

## pricing-card-shell-padding-missing — Pricing adjustment card shell padding utilities missing from Filament CSS
- **Date:** 2026-04-07
- **Error patterns:** no padding, card shell, p-6 missing, pricing adjustment card, filament theme css
- **Root cause:** Filament Tailwind source configuration excluded resources/views/components/**/*, so utilities used only in x-pricing.card-shell (including p-6) were not compiled into the Filament CSS bundle.
- **Fix:** Add resources/views/components/**/* as a Tailwind source in resources/css/filament/admin/theme.css and rebuild assets.
- **Files changed:** resources/css/filament/admin/theme.css
---
