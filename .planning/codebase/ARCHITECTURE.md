# Architecture

**Analysis Date:** 2026-04-10

## Pattern Overview

**Overall:** Laravel 12 + Inertia.js + Filament — Dual-panel monolith

The application runs two distinct surfaces on the same Laravel backend:

1. **Filament Admin Panel** (`/admin`) — Full CRUD for catalog data management (materials, schemas, dimensions, colors, accessories, handles)
2. **Inertia.js SPA** (`/`, `/dashboard`, `/settings/*`) — End-user-facing React app served as a single-page application

Both surfaces share the same Eloquent models and service layer.

**Key Characteristics:**

- Services hold all business logic — controllers and Filament pages delegate to services
- Inertia handles frontend routing; no API endpoints for the React app
- Filament manages internal product catalog; user-facing pricing logic lives in `app/Filament/Pages/Pricing.php` as a Livewire-powered Filament page
- Wayfinder generates type-safe TypeScript bindings (in `resources/js/actions/` and `resources/js/routes/`) from Laravel route definitions

## Layers

**Routes:**

- Purpose: Map HTTP verbs to controllers or Inertia renders
- Location: `routes/web.php`, `routes/settings.php`
- Contains: Named route definitions, auth middleware groups
- Depends on: Controllers, Inertia facade
- Used by: Browser requests

**HTTP Layer:**

- Purpose: Receive requests, validate input via FormRequests, return Inertia responses or redirects
- Location: `app/Http/Controllers/`
- Contains: `Controller.php` (base), `Settings/ProfileController.php`, `Settings/SecurityController.php`, `SystemController.php` (stub)
- Depends on: FormRequests, Services, Inertia
- Used by: Routes

**Form Requests:**

- Purpose: Validation rules encapsulated away from controllers
- Location: `app/Http/Requests/Settings/`
- Contains: `ProfileUpdateRequest.php`, `PasswordUpdateRequest.php`, `ProfileDeleteRequest.php`, `TwoFactorAuthenticationRequest.php`
- Depends on: Concerns (`PasswordValidationRules`, `ProfileValidationRules`)
- Used by: Settings controllers

**Middleware:**

- Purpose: Modify request/response pipeline
- Location: `app/Http/Middleware/`
- Contains:
    - `HandleInertiaRequests.php` — shares global props (auth user, app name, `activeSystems`, `sidebarOpen`) to all Inertia pages
    - `HandleAppearance.php` — manages light/dark theme via cookie
- Depends on: `SystemService`, `Cache` facade, Inertia `Middleware`
- Used by: Every inbound request

**Services:**

- Purpose: Core business logic, kept independent of HTTP or Filament layers
- Location: `app/Services/`
- Contains:
    - `SystemService.php` — fetches active systems, ordered by `order`
    - `SchemaService.php` — fetches schemas filtered by system, status (standard/custom), and active
    - `PricingTableService.php` — orchestrates systems + schemas + dimensions for pricing table display; depends on `SystemService` and `SchemaService`
    - `PricingCalculationService.php` — pure functions for recalculating pricing rows (material cost + working hours × hourly rate)
    - `PricingSaveService.php` — persists pricing row changes to `dimension_pricings` table
    - `DimensionPricingService.php` — dimension-level pricing helpers
- Depends on: Models, Enums
- Used by: Controllers, Filament Pages

**Models (Eloquent):**

- Purpose: Database record representation with relationships, casts, and scopes
- Location: `app/Models/`
- Contains: `System`, `Schema`, `Dimension`, `DimensionPricing`, `Material`, `Color`, `ColorCategory`, `Accesory`, `Handle`, `File`, `User`
- Depends on: Enums, Concerns (`HasFiles`)
- Used by: Services, Filament resources, Livewire pages

**Filament Admin Panel:**

- Purpose: Admin CRUD interface for product catalog, accessible only to authenticated admins
- Location: `app/Filament/`
- Contains:
    - `Resources/` — One resource per entity (AccesoryResource, ColorResource, etc.), each split into Form/Table/Pages sub-namespaces
    - `Pages/Pricing.php` — Live pricing calculation tool as a Filament page (Livewire-powered)
    - `Schemas/Components/` — Shared Filament schema components
- Depends on: Models, Services, Settings
- Used by: Admin users at `/admin`

**Settings:**

- Purpose: Persistent app-level configuration stored in database via Spatie Laravel Settings
- Location: `app/Settings/`
- Contains: `PricingSettings.php` (hourly_rate, global_adjustment)
- Schema stored in `database/settings/`
- Depends on: `spatie/laravel-settings`
- Used by: `Filament/Pages/Pricing.php`

**Livewire UI Components:**

- Purpose: Reusable form inputs used inside Filament Blade views
- Location: `app/Livewire/Ui/`
- Contains: `FormInput.php`, `FormSelect.php`
- Depends on: Livewire `#[Modelable]` attribute pattern
- Used by: Filament Blade templates

**Providers:**

- Purpose: Bootstrap application-level configuration and bind services
- Location: `app/Providers/`
- Contains:
    - `AppServiceProvider.php` — configures Filament Select defaults, CarbonImmutable dates, password rules, prohibits destructive DB commands in production
    - `Filament/AdminPanelProvider.php` — registers the Filament `/admin` panel, discovers resources/pages/widgets automatically
    - `FortifyServiceProvider.php` — wires Fortify authentication actions

**Inertia React Frontend:**

- Purpose: User-facing SPA with sidebar layout, auth pages, settings pages
- Location: `resources/js/`
- Contains: Pages, layouts, components, hooks, type definitions, Wayfinder-generated route bindings
- Depends on: Inertia React adapter, shared props from `HandleInertiaRequests`
- Used by: Browser (served by Vite)

## Data Flow

**Admin CRUD Flow:**

1. Admin navigates to `/admin/materials`
2. `AdminPanelProvider` routes to `MaterialResource`
3. `MaterialResource::table()` delegates to `MaterialsTable::configure()`
4. `MaterialResource::form()` delegates to `MaterialForm::configure()`
5. Filament performs CRUD directly against `Material` Eloquent model
6. File uploads delegated to `HasFiles` concern on `Schema` model

**Pricing Calculation Flow:**

1. Admin opens `/admin/pricing` (Filament `Pricing` page)
2. `mount()` loads `PricingSettings` (hourly_rate, global_adjustment)
3. User selects System → `updatedSelectedSystem()` resets schema/rows
4. User selects Schema → `updatedSelectedSchema()` calls `PricingTableService::loadTable()`
5. `PricingTableService` uses `SchemaService` + `DimensionService` to build `rows` array
6. User edits `working_hours` → Livewire `updated()` calls `PricingCalculationService::recalculateRow()`
7. User saves → `PricingSaveService` persists `DimensionPricing` records

**Inertia Page Flow:**

1. Browser requests `/dashboard`
2. `HandleAppearance` middleware sets theme header
3. `HandleInertiaRequests::share()` injects auth user, app name, `activeSystems` (cached 1 hour), `sidebarOpen` cookie
4. Controller returns `Inertia::render('dashboard')` or route uses `Route::inertia()`
5. Inertia loads `resources/js/pages/dashboard.tsx` via `resolvePageComponent`
6. React renders with `AppLayout` (sidebar layout) wrapping page content
7. Wayfinder route bindings (`@/routes/*`) provide type-safe link hrefs

**State Management:**

- Server-side state: Filament `Pricing` page uses Livewire reactive properties (`$rows`, `$selectedSystem`, etc.)
- Client-side state: React component state; global shared state via `usePage().props` (Inertia page props)
- Theme/appearance: Cookie-based, read by `HandleAppearance` middleware and `use-appearance.tsx` hook

## Key Abstractions

**Filament Resource:**

- Purpose: Self-contained admin CRUD module for one entity
- Examples: `app/Filament/Resources/Systems/SystemResource.php`
- Pattern: Resource class delegates to `{Entity}Form::configure()` and `{Entity}Table::configure()` static classes

**Service:**

- Purpose: Encapsulates domain logic away from HTTP/Filament layers
- Examples: `app/Services/PricingCalculationService.php`, `app/Services/SchemaService.php`
- Pattern: Stateless classes injected via `app()` helper or constructor injection

**HasFiles Concern:**

- Purpose: Polymorphic file attachment mixin
- Examples: `app/Concerns/HasFiles.php` used on `Schema` model
- Pattern: `files()` morphMany + `addFile()`, `getFiles()`, `getFirstFileUrl()` helpers

**Wayfinder Bindings:**

- Purpose: Type-safe TypeScript mapping of Laravel routes to callable functions
- Examples: `resources/js/routes/`, `resources/js/actions/`
- Pattern: `import { dashboard } from '@/routes'` → `href={dashboard()}` in components

## Entry Points

**Web App:**

- Location: `routes/web.php`
- Triggers: HTTP requests from browser
- Responsibilities: Route auth-guarded and public pages to controllers or Inertia renders

**Filament Admin:**

- Location: `app/Providers/Filament/AdminPanelProvider.php`
- Triggers: Requests to `/admin/*`
- Responsibilities: Panel bootstrap, resource/page auto-discovery

**Frontend Bootstrap:**

- Location: `resources/js/app.tsx`
- Triggers: Vite bundle load in browser
- Responsibilities: Create Inertia app, resolve pages from `resources/js/pages/**/*.tsx`, wrap in `TooltipProvider`, initialize theme

**Console:**

- Location: `routes/console.php`
- Triggers: `php artisan` invocations

## Error Handling

**Strategy:** Controller-level validation via FormRequests; Filament pages use Filament Notification for user feedback; no global exception transformer beyond Laravel's default.

**Patterns:**

- FormRequests throw `ValidationException` automatically returned as redirect with errors
- Filament pages call `Notification::make()->danger()->send()` on failure
- Livewire property updates are guarded by null checks before service calls

## Cross-Cutting Concerns

**Logging:** Laravel default (no custom logger configured)
**Validation:** FormRequest classes for HTTP; Filament form validation inline in form schema classes
**Authentication:** Laravel Fortify (email/password + 2FA); Filament uses its own `Authenticate` middleware at `/admin`
**Caching:** `Cache::remember('active_systems', ...)` in `HandleInertiaRequests` — 1-hour TTL

---

_Architecture analysis: 2026-04-10_
