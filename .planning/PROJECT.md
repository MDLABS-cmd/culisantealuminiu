# USI Culisante Aluminiu

## What This Is

A web-based aluminium sliding window/door system configurator serving both B2B (dealers/resellers) and B2C (end customers). Users select a system, choose a schema (profile type), pick dimensions, accessories, handles, and glass colours to receive a live-calculated price. The admin panel (Filament) allows management of all configurator data; the customer-facing interface guides buyers through the configuration flow.

## Core Value

A customer can configure a sliding aluminium window/door system and receive an accurate price — end-to-end, without human intervention.

## Requirements

### Validated

- ✓ Admin panel (Filament) for managing Systems, Schemas, Dimensions, Accessories, Handles, Colors, Materials — existing
- ✓ Pricing records per dimension × material (DimensionPricing) — existing
- ✓ App header with system tabs navigation — existing
- ✓ TypeScript model types for all entities — existing
- ✓ Inertia shared props: `activeSystems` passed to all pages — existing

### Active

- [ ] Customer configurator landing page — system selection → schema selection → dimension/accessory/handle/color selection
- [ ] React context/provider storing all user selections across the configurator
- [ ] Live price calculation: `price_without_vat` (selected dimension) + accessory prices + handle price
- [ ] Summary component displaying current configuration and running price
- [ ] Hybrid data loading: Inertia props for initial systems; API calls when schema is selected
- [ ] Details/quote request form (subsequent phase — CTA placeholder only in Phase 1)

### Out of Scope

- Checkout / payment processing — not requested
- PDF quote generation — future milestone
- User account / order history — future milestone
- Multi-language support — not mentioned

## Context

- **Stack**: Laravel 11 + Inertia.js v2 + React 18 + TypeScript + Tailwind CSS v4 (CSS-first `@theme`)
- **Admin**: Filament v3 at `/admin` for all data management
- **Auth**: Laravel Fortify for authentication; guest access expected for configurator
- **Routing**: Typed Wayfinder route helpers (`dashboard()`, `toUrl()`)
- **Icons**: lucide-react
- **Components**: shadcn/ui patterns (Button, DropdownMenu, Sheet, etc.)
- **Testing**: Pest PHP for backend; no frontend test framework configured yet
- **Branch**: `customer-page` — active development branch
- **Data model**: System → Schema → Dimension + AccessorySchema + HandleSchema + ColorCategorySchema

## Constraints

- **Tech stack**: Laravel + Inertia + React — no API-only backend, no separate SPA build
- **Pricing**: Additive formula — `DimensionPricing.price_without_vat` + sum of selected accessory prices + handle price
- **Phase 1 CTA**: After configuration is complete, route to a details form (not yet implemented — placeholder only)
- **Data loading**: Systems loaded via Inertia shared props; schema-level data (dimensions, accessories, handles, colors) loaded via API on schema selection

## Key Decisions

| Decision                                  | Rationale                                                                                                    | Outcome   |
| ----------------------------------------- | ------------------------------------------------------------------------------------------------------------ | --------- |
| Hybrid Inertia + API loading              | Systems/schemas load with page (fast); heavy per-schema data loads on demand (avoids huge initial payload)   | — Pending |
| React Context for selection state         | Multi-step config requires shared state without prop drilling; avoids over-engineering with global state lib | — Pending |
| price_without_vat as dimension base price | Pre-calculated in DimensionPricing records, no client-side material formula needed                           | — Pending |
| Tailwind v4 CSS-first config              | Already established in project; no tailwind.config.js                                                        | ✓ Good    |
| Dark mode removed                         | Simplified to light-only; no dark: classes ever activate                                                     | ✓ Good    |

---

_Last updated: April 10, 2026 after project initialization_

## Evolution

This document evolves at phase transitions and milestone boundaries.

**After each phase transition** (via `/gsd-transition`):

1. Requirements invalidated? → Move to Out of Scope with reason
2. Requirements validated? → Move to Validated with phase reference
3. New requirements emerged? → Add to Active
4. Decisions to log? → Add to Key Decisions
5. "What This Is" still accurate? → Update if drifted

**After each milestone** (via `/gsd-complete-milestone`):

1. Full review of all sections
2. Core Value check — still the right priority?
3. Audit Out of Scope — reasons still valid?
4. Update Context with current state
