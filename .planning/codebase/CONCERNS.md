# Codebase Concerns

**Analysis Date:** 2026-04-10

## Tech Debt

**Pricing Data Model Mismatch:**
- Issue: The persistence service upserts pricing by composite key (`dimension_id`, `material_id`), but the schema enforces `dimension_id` as globally unique, creating incompatible expectations.
- Files: `app/Services/DimensionPricingService.php`, `database/migrations/2026_04_04_000000_create_dimension_pricings_table.php`, `app/Models/Dimension.php`
- Impact: Material-specific pricing cannot be represented reliably; future changes will produce confusing overwrite behavior or failed assumptions.
- Fix approach: Align model + migration + service semantics. Either keep one pricing row per dimension (drop `material_id` from uniqueness logic and service keying) or support many per dimension (remove unique on `dimension_id`, change relation to `hasMany`, and query by material/schema context).

**Service API Misuse in Pricing Table Loader:**
- Issue: `loadTable()` calls `getSchemaWithMaterial($systemId)` even though that method expects a schema ID.
- Files: `app/Services/PricingTableService.php`, `app/Services/SchemaService.php`
- Impact: Wrong material lookup, null material assignment, and incorrect pricing table hydration when system ID and schema ID differ.
- Fix approach: Pass `$schemaId` to `getSchemaWithMaterial()` and add regression tests for system/schema combinations.

**Domain Naming Inconsistency (Accesory/Accessory):**
- Issue: Model/table/pivot naming uses `Accesory` (typo) consistently in backend and frontend types.
- Files: `app/Models/Accesory.php`, `database/migrations/2026_04_09_065028_create_accesories_table.php`, `database/migrations/2026_04_09_065819_create_accesory_schema_table.php`, `resources/js/types/models.ts`
- Impact: Long-term maintainability cost and integration friction with external systems expecting `accessory` naming.
- Fix approach: Plan controlled rename (model, table, pivot, TS types, route/resource names) with compatibility migration and alias period.

## Known Bugs

**Pricing Material Hydration Uses Wrong Identifier:**
- Symptoms: Selected schema may not load its expected material; pricing rows can bind to wrong/null material.
- Files: `app/Services/PricingTableService.php`
- Trigger: Selecting schema in pricing page when selected system ID does not equal schema ID.
- Workaround: None reliable in UI; bug requires code fix.

**Potential Data Integrity Drift in Pricing Rows:**
- Symptoms: Application code implies per-material rows while schema currently allows one row per dimension.
- Files: `app/Services/DimensionPricingService.php`, `app/Models/Dimension.php`, `database/migrations/2026_04_04_000000_create_dimension_pricings_table.php`
- Trigger: Any workflow trying to save or reason about multiple materials per dimension.
- Workaround: Treat pricing as one-per-dimension everywhere until schema/service are aligned.

## Security Considerations

**HTML Injection Surface in 2FA QR Rendering:**
- Risk: Direct `dangerouslySetInnerHTML` use can become an XSS vector if SVG content source changes or is insufficiently sanitized upstream.
- Files: `resources/js/components/two-factor-setup-modal.tsx`
- Current mitigation: Intended source is trusted backend-generated QR payload.
- Recommendations: Enforce strict server-side SVG generation/sanitization guarantees and add tests/assertions that untrusted HTML is never injected.

**Unrestricted File Storage Metadata Trust:**
- Risk: File ingestion stores original filename and MIME-derived type without explicit extension/type allowlisting at this layer.
- Files: `app/Concerns/HasFiles.php`, `app/Models/File.php`, `database/migrations/2026_03_24_130000_create_files_table.php`
- Current mitigation: Type enum mapping and framework upload handling.
- Recommendations: Add explicit validation policy before `addFile()` usage (max size, MIME allowlist, extension checks, collection-specific constraints), and store sanitized display names.

**Over-broad Shared User Payload in Inertia Middleware:**
- Risk: Sharing full authenticated user model increases accidental exposure surface if hidden/casts/config changes.
- Files: `app/Http/Middleware/HandleInertiaRequests.php`, `app/Models/User.php`
- Current mitigation: Hidden attributes on `User` model.
- Recommendations: Share minimal explicit user DTO fields (id, name, email, permissions) instead of whole model.

## Performance Bottlenecks

**Global Shared Data Query Serialization Cost:**
- Problem: Active systems are shared for every Inertia response; cache helps DB load but still serializes collection into each response.
- Files: `app/Http/Middleware/HandleInertiaRequests.php`, `app/Services/SystemService.php`
- Cause: Cross-app shared prop with model payload on all pages.
- Improvement path: Share only fields required by navigation, and lazy/deferred props where possible.

**File Relation Lookup Lacks Explicit Composite Indexing Strategy:**
- Problem: Morph relation queries on files can degrade as `files` table grows.
- Files: `database/migrations/2026_03_24_130000_create_files_table.php`, `app/Concerns/HasFiles.php`
- Cause: No explicit additional indexing beyond default `morphs` behavior for common access patterns like `(fileable_type, fileable_id, collection)`.
- Improvement path: Add targeted indexes for dominant query paths and validate with query plans.

**Potential N+1/Over-fetch in Pricing Table Material + Dimensions:**
- Problem: Pricing table loads dimensions with related pricing but no explicit projection/minimal select strategy.
- Files: `app/Services/PricingTableService.php`, `app/Models/Dimension.php`
- Cause: Full model hydration for table-oriented data path.
- Improvement path: Select only required columns and verify relation strategy once pricing cardinality is clarified.

## Fragile Areas

**Pricing Save Path Lacks Defensive Validation:**
- Files: `app/Filament/Pages/Pricing.php`, `app/Services/PricingSaveService.php`, `app/Services/DimensionPricingService.php`
- Why fragile: Save path assumes row structure and numeric values are valid; malformed payloads can trigger runtime errors or invalid persisted values.
- Safe modification: Introduce dedicated DTO/validator for row payload, strict numeric bounds, and fail-fast error handling before transaction.
- Test coverage: No dedicated pricing feature/unit tests detected under `tests/`.

**Schema/Dimension/Pricing Relationship Contract Is Unclear:**
- Files: `app/Models/Schema.php`, `app/Models/Dimension.php`, `app/Models/DimensionPricing.php`, `app/Services/PricingTableService.php`
- Why fragile: Cardinality semantics differ across model relation (`hasOne`), migration uniqueness, and service upsert key strategy.
- Safe modification: Define canonical relationship contract first, then migrate service/model/migration together in one change set.
- Test coverage: No contract tests for relationship assumptions.

**Missing Requested Livewire Pricing Module:**
- Files: `app/Livewire/Pricing/` (not present), `app/Livewire/Ui/FormInput.php`, `app/Livewire/Ui/FormSelect.php`
- Why fragile: Documentation/instructions reference a Livewire pricing area that currently does not exist, indicating drift between expected and actual architecture.
- Safe modification: Update docs/plans to Filament-based pricing implementation or add the missing module explicitly.
- Test coverage: No tests covering a Livewire pricing path.

## Scaling Limits

**Pricing Computation and Save Are In-memory Page-bound:**
- Current capacity: Works for small/medium row counts managed in page state.
- Limit: Large dimension sets increase frontend state updates and transaction payload sizes.
- Scaling path: Batch updates server-side, paginate/virtualize UI rows, and use incremental persistence.
- Files: `app/Filament/Pages/Pricing.php`, `app/Services/PricingCalculationService.php`, `app/Services/PricingSaveService.php`

## Dependencies at Risk

**Floating-point Currency Arithmetic:**
- Risk: Monetary values are computed/stored as floats in pricing logic and DB schema.
- Impact: Rounding drift over repeated operations and inconsistent totals across environments.
- Migration plan: Use fixed precision decimal columns and decimal-safe arithmetic strategy throughout services.
- Files: `app/Services/PricingCalculationService.php`, `database/migrations/2026_04_04_000000_create_dimension_pricings_table.php`

## Missing Critical Features

**No Explicit Authorization Guard in Pricing Save Flow:**
- Problem: Page-level access control is not visible in pricing save method itself.
- Blocks: Clear defense-in-depth guarantees for unauthorized mutation paths.
- Files: `app/Filament/Pages/Pricing.php`

**No Explicit Validation Layer for Pricing Row Payloads:**
- Problem: Pricing updates are accepted from mutable page state with no formal request/rule object.
- Blocks: Reliable input contracts and safer refactoring.
- Files: `app/Filament/Pages/Pricing.php`, `app/Services/DimensionPricingService.php`

## Test Coverage Gaps

**Pricing Domain Untested:**
- What's not tested: pricing table load behavior, schema/material resolution, recalculation math, and persistence semantics.
- Files: `app/Filament/Pages/Pricing.php`, `app/Services/PricingTableService.php`, `app/Services/PricingCalculationService.php`, `app/Services/PricingSaveService.php`
- Risk: Regressions in core pricing behavior ship unnoticed.
- Priority: High

**File Upload and Fileable Behavior Untested:**
- What's not tested: file attachment lifecycle, MIME/type mapping, URL generation assumptions, collection filtering.
- Files: `app/Concerns/HasFiles.php`, `app/Models/File.php`
- Risk: Security and data integrity defects in file handling.
- Priority: High

**Model Relationship Contract Tests Missing:**
- What's not tested: dimension-pricing cardinality consistency against migration constraints.
- Files: `app/Models/Dimension.php`, `app/Models/DimensionPricing.php`, `database/migrations/2026_04_04_000000_create_dimension_pricings_table.php`
- Risk: Silent mismatch between code expectations and database constraints.
- Priority: Medium

---

*Concerns audit: 2026-04-10*
