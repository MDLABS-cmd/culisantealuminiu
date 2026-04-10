# Codebase Structure

**Analysis Date:** 2026-04-10

## Directory Layout

```
usi-culisante/
├── app/
│   ├── Actions/Fortify/        # Fortify auth action overrides (CreateNewUser, ResetUserPassword)
│   ├── Concerns/               # Reusable traits (HasFiles, PasswordValidationRules, ProfileValidationRules)
│   ├── Enums/                  # PHP backed enums (SchemaPriceTypeEnum, FileTypeEnum, HandleTypeEnum)
│   ├── Filament/
│   │   ├── Pages/              # Custom Filament full-page components (Pricing.php)
│   │   ├── Resources/          # One folder per entity, each with Pages/, Schemas/, Tables/
│   │   └── Schemas/Components/ # Shared Filament schema form components
│   ├── Http/
│   │   ├── Controllers/        # Inertia controllers; Settings/ sub-namespace
│   │   ├── Middleware/         # HandleInertiaRequests.php, HandleAppearance.php
│   │   └── Requests/Settings/  # FormRequest validation classes
│   ├── Livewire/Ui/            # Reusable Livewire form input components
│   ├── Models/                 # Eloquent models
│   ├── Providers/
│   │   ├── Filament/           # AdminPanelProvider.php
│   │   ├── AppServiceProvider.php
│   │   └── FortifyServiceProvider.php
│   ├── Services/               # Business logic services
│   └── Settings/               # Spatie laravel-settings classes
├── bootstrap/                  # Laravel bootstrap files
├── config/                     # Laravel config files
├── database/
│   ├── factories/              # Eloquent model factories
│   ├── migrations/             # Database migration files
│   ├── seeders/                # Database seeders
│   └── settings/               # Spatie settings migration files
├── public/                     # Webroot; compiled assets in public/build/
├── resources/
│   ├── css/
│   │   └── filament/admin/     # Filament custom Tailwind theme
│   ├── js/
│   │   ├── actions/            # Wayfinder-generated TS action bindings (mirrors PHP class tree)
│   │   ├── components/         # App-level React components
│   │   │   └── ui/             # shadcn/ui primitives (button, input, dialog, etc.)
│   │   ├── hooks/              # React custom hooks
│   │   ├── layouts/            # Page layout wrappers
│   │   │   ├── app/            # App layouts (sidebar, header variants)
│   │   │   ├── auth/           # Auth page layouts (card, simple, split)
│   │   │   └── settings/       # Settings sub-layout
│   │   ├── lib/                # Utility functions (utils.ts → cn())
│   │   ├── pages/              # Inertia page components (one file per route)
│   │   │   ├── auth/           # Auth pages (login, register, forgot-password, etc.)
│   │   │   └── settings/       # Settings pages (profile, security, appearance)
│   │   ├── routes/             # Wayfinder-generated TS route bindings
│   │   ├── types/              # TypeScript type definitions
│   │   └── app.tsx             # Inertia app bootstrap
│   └── views/                  # Blade templates (Filament, Livewire, app.blade.php)
├── routes/
│   ├── web.php                 # Main web routes
│   ├── settings.php            # Settings sub-routes (profile, security, appearance)
│   └── console.php             # Artisan console routes
└── tests/                      # Pest/PHPUnit test suites
```

## Directory Purposes

**`app/Filament/Resources/{Entity}/`:**

- Purpose: Admin CRUD for one domain entity
- Contains: `{Entity}Resource.php` (main), `Pages/` (List/Create/Edit), `Schemas/{Entity}Form.php`, `Tables/{Entity}Table.php`
- Key files: `AccesoryResource.php`, `SystemResource.php`, `SchemaResource.php`
- Pattern: Resource delegates form/table config to dedicated static classes

**`app/Services/`:**

- Purpose: All business logic — no HTTP or Filament dependencies
- Contains: `SystemService.php`, `SchemaService.php`, `PricingTableService.php`, `PricingCalculationService.php`, `PricingSaveService.php`, `DimensionPricingService.php`
- Injected via `app()` helper in Filament pages or constructor injection

**`app/Models/`:**

- Purpose: Eloquent ORM models with relationships, casts, scopes
- Contains: `System`, `Schema`, `Dimension`, `DimensionPricing`, `Material`, `Color`, `ColorCategory`, `Accesory`, `Handle`, `File`, `User`
- Use `#[Fillable([...])]` PHP attribute for mass assignment (not `$fillable` array)

**`app/Concerns/`:**

- Purpose: Reusable trait mixins for models and form requests
- Contains: `HasFiles.php` (polymorphic file attachments), `PasswordValidationRules.php`, `ProfileValidationRules.php`

**`app/Enums/`:**

- Purpose: Type-safe PHP backed enums shared across models and Filament
- Contains: `SchemaPriceTypeEnum.php` (standard/custom), `FileTypeEnum.php`, `HandleTypeEnum.php`

**`app/Settings/`:**

- Purpose: Database-persistent application settings via `spatie/laravel-settings`
- Contains: `PricingSettings.php` (global_adjustment, hourly_rate)
- Backed by `database/settings/` migrations

**`resources/js/pages/`:**

- Purpose: One `.tsx` file per Inertia route; file path maps to `Inertia::render()` string
- `auth/*.tsx` — authentication flow pages
- `settings/*.tsx` — user settings pages
- `dashboard.tsx`, `welcome.tsx` — main app pages

**`resources/js/components/`:**

- Purpose: Reusable React components at the application level
- `ui/` — shadcn/ui primitives (never modify directly — regenerate with shadcn CLI)
- Root components are app-specific (AppSidebar, AppHeader, NavMain, etc.)

**`resources/js/layouts/`:**

- Purpose: Page wrapper components that provide consistent chrome
- `app-layout.tsx` — primary layout (re-exports sidebar variant)
- `auth-layout.tsx` — authentication layout wrapper
- `app/app-sidebar-layout.tsx` — full sidebar + content shell
- `settings/layout.tsx` — settings page sub-layout

**`resources/js/types/`:**

- Purpose: TypeScript type definitions shared across all frontend code
- `index.ts` — re-exports all types (single import point: `import type { X } from '@/types'`)
- `models.ts` — mirrors all PHP Eloquent models as TypeScript types + relation variants
- `auth.ts` — User, Auth, TwoFactor types
- `navigation.ts` — BreadcrumbItem, NavItem
- `ui.ts` — UI-specific prop types
- `global.d.ts` — augments `@inertiajs/core` with `sharedPageProps` type

**`resources/js/actions/`:**

- Purpose: Wayfinder-generated TypeScript bindings for making typed HTTP requests to Laravel controllers
- Mirrors the PHP class tree: `App/Http/Controllers/Settings/ProfileController.ts`
- Use for `<Form {...ProfileController.update.form()}>` patterns

**`resources/js/routes/`:**

- Purpose: Wayfinder-generated TypeScript functions for type-safe route URL generation
- Use for `href={dashboard()}` or `href={edit()}` in Link components — never hardcode URLs

**`resources/js/hooks/`:**

- Purpose: Custom React hooks
- Contains: `use-appearance.tsx`, `use-clipboard.ts`, `use-current-url.ts`, `use-initials.tsx`, `use-mobile.tsx`, `use-mobile-navigation.ts`, `use-two-factor-auth.ts`

## Key File Locations

**Entry Points:**

- `routes/web.php`: All web route definitions
- `resources/js/app.tsx`: React/Inertia app bootstrap
- `app/Providers/Filament/AdminPanelProvider.php`: Filament panel registration

**Configuration:**

- `app/Http/Middleware/HandleInertiaRequests.php`: Inertia shared props (auth, activeSystems, sidebarOpen, name)
- `app/Providers/AppServiceProvider.php`: Global app defaults (date, password, Filament select)
- `app/Settings/PricingSettings.php`: Pricing global settings (hourly_rate, global_adjustment)

**Core Logic:**

- `app/Services/PricingCalculationService.php`: Pricing math (material cost + working hours × rate)
- `app/Services/PricingTableService.php`: Assembles full pricing table from systems/schemas/dimensions
- `app/Filament/Pages/Pricing.php`: Livewire-powered pricing management page

**TypeScript Types:**

- `resources/js/types/index.ts`: Single import source for all types
- `resources/js/types/models.ts`: All domain model types + relationship variants
- `resources/js/types/global.d.ts`: Inertia shared props type augmentation

**Models:**

- `app/Models/Schema.php`: Central domain model — belongs to System + Material, has many Dimensions
- `app/Models/DimensionPricing.php`: Pricing per dimension per material
- `app/Concerns/HasFiles.php`: Polymorphic file attachment trait

## Naming Conventions

**Files (PHP):**

- Models: `PascalCase.php` (e.g., `ColorCategory.php`)
- Services: `{Domain}Service.php` (e.g., `PricingCalculationService.php`)
- Filament Resources: `{Entity}Resource.php` in `Resources/{Entities}/` folder
- Filament Form classes: `{Entity}Form.php` in `Schemas/` sub-folder
- Filament Table classes: `{Entities}Table.php` in `Tables/` sub-folder
- Enums: `{Name}Enum.php` (e.g., `SchemaPriceTypeEnum.php`)

**Files (TypeScript/React):**

- Pages: `kebab-case.tsx` under `pages/` matching Inertia render string
- Components: `kebab-case.tsx` (e.g., `app-sidebar.tsx`, `nav-main.tsx`)
- shadcn/ui primitives: `kebab-case.tsx` under `components/ui/`
- Hooks: `use-{name}.ts` or `use-{name}.tsx`
- Types: `{domain}.ts` under `types/`

**Directories:**

- Filament resources: `PluralPascalCase/` (e.g., `ColorCategories/`, `Systems/`)
- Routes/actions (Wayfinder): mirror PHP namespace tree with `/` separators

**PHP Patterns:**

- Mass assignment via `#[Fillable([...])]` attribute (not `$fillable` array property)
- Model scopes named `scopeActive()`, `scopeStatus()`
- Enum `options()` static method returns label arrays for Filament selects

## Where to Add New Code

**New domain entity (e.g., `Widget`):**

1. Migration: `database/migrations/{timestamp}_create_widgets_table.php`
2. Model: `app/Models/Widget.php` — use `#[Fillable([...])]` attribute
3. Filament resource: `app/Filament/Resources/Widgets/WidgetResource.php` + Pages/, Schemas/, Tables/ sub-folders
4. Service (if needed): `app/Services/WidgetService.php`
5. TypeScript type: Add to `resources/js/types/models.ts`
6. Run Wayfinder: regenerate `resources/js/actions/` and `resources/js/routes/`

**New Inertia page (e.g., `catalog`):**

1. Route: Add to `routes/web.php` (or new `routes/catalog.php` required in `web.php`)
2. Controller: `app/Http/Controllers/CatalogController.php` returning `Inertia::render('catalog')`
3. Page component: `resources/js/pages/catalog.tsx`
4. Layout: Wrap with `<AppLayout>` for authenticated pages

**New settings group:**

1. Settings class: `app/Settings/{Name}Settings.php` extending `Spatie\LaravelSettings\Settings`
2. Migration: `database/settings/{timestamp}_create_{name}_settings.php`

**New shared utility (TypeScript):**

- Helper function: `resources/js/lib/utils.ts`
- Custom hook: `resources/js/hooks/use-{name}.ts`

**New Filament page (custom, not CRUD):**

- Create in `app/Filament/Pages/{PageName}.php` extending `Filament\Pages\Page`
- Blade view in `resources/views/filament/pages/{page-name}.blade.php`

## Special Directories

**`.planning/`:**

- Purpose: GSD project planning documents (phases, roadmap, codebase analysis)
- Generated: No (hand-maintained)
- Committed: Yes

**`resources/js/actions/` and `resources/js/routes/`:**

- Purpose: Auto-generated by Wayfinder from PHP route/controller definitions
- Generated: Yes (`php artisan wayfinder:generate`)
- Committed: Yes
- Do NOT edit manually — regenerate after adding routes/controllers

**`public/build/`:**

- Purpose: Vite compiled frontend assets
- Generated: Yes (`npm run build`)
- Committed: No

**`database/settings/`:**

- Purpose: Spatie laravel-settings migration files that define settings schema
- Generated: No
- Committed: Yes

---

_Structure analysis: 2026-04-10_
