# Technology Stack

**Analysis Date:** 2026-04-10

## Languages

**Primary:**

- PHP 8.3+ - Laravel backend (`app/`, `config/`, `routes/`, `database/`)
- TypeScript 5.7 - React frontend (`resources/js/`)

**Secondary:**

- CSS - Tailwind v4 via `resources/css/app.css`

## Runtime

**Environment:**

- PHP 8.3 (served locally via Laravel Herd)
- Node.js (frontend bundling only — not a Node server)

**Package Manager:**

- Composer (PHP) — lockfile: `composer.lock` present
- pnpm (Node, lockfileVersion 9.0) — lockfile: `pnpm-lock.yaml` present

## Frameworks

**Backend:**

- Laravel 13.0 — core PHP framework (`app/`, `routes/`, `config/`)
- Inertia.js Laravel adapter 2.0 (`inertiajs/inertia-laravel`) — SPA bridge, no JSON API
- Laravel Fortify 1.34 — authentication backend (login, register, 2FA, password reset)
- Filament 5.0 (`filament/filament`) — admin panel at `/admin`, includes Livewire
- Livewire — bundled via Filament; used directly in `app/Livewire/Ui/`
- Spatie Laravel Settings 3.7 — typed settings objects (`app/Settings/`)

**Frontend:**

- React 19.2 — UI library (`resources/js/`)
- Inertia.js React 2.3.7 (`@inertiajs/react`) — page/form/router SPA bridge
- Tailwind CSS 4.x — utility-first CSS
- Radix UI primitives — accessible components (`@radix-ui/react-*`, ~14 packages)
- Headless UI 2.2 (`@headlessui/react`) — additional accessible components

**Testing:**

- Pest PHP 4.4 (`pestphp/pest`) — test runner
- Pest Laravel Plugin 4.1 (`pestphp/pest-plugin-laravel`) — Laravel test utilities

**Build/Dev:**

- Vite 8.0 — frontend bundler (`vite.config.ts`)
- `@vitejs/plugin-react` 5.2.0 — React + Babel React Compiler plugin
- `@tailwindcss/vite` 4.1.11 — Tailwind Vite plugin (no `tailwind.config.*` file)
- `laravel-vite-plugin` 3.0.0 — Laravel-Vite bridge (manifest, SSR, HMR)
- `@laravel/vite-plugin-wayfinder` 0.1.3 — generates typed TypeScript route functions
- ESLint 9 + `typescript-eslint` 8.23 — linting (`eslint.config.js`)
- Prettier 3.4 + `prettier-plugin-tailwindcss` — formatting (`.prettierrc`)
- Laravel Pint 1.27 — PHP code style fixer

## Key Dependencies

**Critical:**

- `laravel/wayfinder` 0.1.14 — generates type-safe route/action TS functions; imported from `@/actions` and `@/routes`
- `@inertiajs/react` 2.3.7 — all page navigation and form submissions go through Inertia
- `filament/filament` 5.0 — entire admin panel CRUD for resources (Colors, Materials, Dimensions, Systems, etc.)
- `spatie/laravel-settings` 3.7 — app settings stored as typed PHP objects (`app/Settings/PricingSettings.php`)

**UI Primitives:**

- `@radix-ui/react-dialog`, `dropdown-menu`, `select`, `tooltip`, `checkbox`, etc. — base for shadcn-style UI in `resources/js/components/ui/`
- `lucide-react` 0.475 — icon set
- `class-variance-authority` 0.7.1 (`cva`) — component variant utility
- `clsx` 2.1.1 + `tailwind-merge` 3.0.1 — class name composition (`cn()` helper)
- `input-otp` 1.4.2 — OTP input for 2FA (`resources/js/components/ui/input-otp.tsx`)
- `tw-animate-css` — animation utilities imported in `app.css`

**Dev Tooling:**

- `fruitcake/laravel-debugbar` 4.1 — debug toolbar (dev only)
- `laravel/pail` 1.2.5 — log tail viewer (dev only)
- `laravel/sail` 1.53 — Docker dev environment
- `concurrently` 9.0 — runs server, queue, and Vite simultaneously via `composer run dev`

## Configuration

**Environment:**

- Single `.env` file (`.env.example` committed)
- Key env vars: `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_URL`, `DB_CONNECTION`, `DB_DATABASE`, `MAIL_MAILER`, `QUEUE_CONNECTION`, `CACHE_STORE`, `SESSION_DRIVER`
- Frontend env: `VITE_APP_NAME` (only env var exposed to frontend)

**Build:**

- `vite.config.ts` — entry points: `resources/css/app.css`, `resources/js/app.tsx`; SSR bundle: `resources/js/ssr.tsx`
- `tsconfig.json` — strict mode, ESNext target, bundler module resolution, `noEmit: true`
- No `tailwind.config.*` — Tailwind v4 configured entirely via CSS `@theme` in `resources/css/app.css`
- Filament custom theme: `resources/css/filament/admin/theme.css`

## Platform Requirements

**Development:**

- PHP 8.3+, Composer
- Node.js with pnpm
- SQLite (default) or MySQL/MariaDB
- Run: `composer run dev` (starts PHP server, queue worker, Vite)

**Production:**

- PHP 8.3+ web server
- SQLite or MySQL/MariaDB
- Queue worker required (`QUEUE_CONNECTION=database`)
- SSR enabled (`php artisan inertia:start-ssr`) — SSR server at port 13714

---

_Stack analysis: 2026-04-10_
