# External Integrations

**Analysis Date:** 2026-04-10

## APIs & External Services

**Email Delivery (configured, not active by default):**

- Postmark — transactional email
    - SDK: Laravel built-in transport (`postmark` mailer)
    - Auth: `POSTMARK_API_KEY`
- Resend — transactional email
    - SDK: Laravel built-in transport (`resend` mailer)
    - Auth: `RESEND_API_KEY`
- AWS SES — transactional email
    - SDK: Laravel built-in transport (`ses` / `ses-v2` mailer)
    - Auth: `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`

**Notifications:**

- Slack — bot notifications
    - SDK: Laravel Slack notification channel
    - Auth: `SLACK_BOT_USER_OAUTH_TOKEN`, `SLACK_BOT_USER_DEFAULT_CHANNEL`

**Default (dev):** `MAIL_MAILER=log` — all mail goes to log file, no external delivery

## Data Storage

**Databases:**

- SQLite — default/development (`DB_CONNECTION=sqlite`)
    - File: `database/database.sqlite`
    - Connection: `DB_DATABASE`
- MySQL 8+ — production option (`DB_CONNECTION=mysql`)
    - Connection: `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- MariaDB — production option (`DB_CONNECTION=mariadb`)
    - Same connection vars as MySQL

**ORM:** Laravel Eloquent (no standalone ORM package)
**Schema:** Laravel migrations (`database/migrations/`)

**Queues:**

- Database queue driver (default) — table: `jobs`
    - Connection: `QUEUE_CONNECTION=database`
- AWS SQS — available option
    - Auth: `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `SQS_PREFIX`
- BeanstalkD — available option
- Redis — available option (`REDIS_HOST`, `REDIS_PORT`, `REDIS_PASSWORD`)

**Cache:**

- Database cache driver (default) — `CACHE_STORE=database`
- Redis — available option (configured via `REDIS_*` vars)
- Memcached — available option (`MEMCACHED_HOST`)

**File Storage:**

- Local filesystem (default) — `storage/app/private/`
    - `FILESYSTEM_DISK=local`
- AWS S3 — available option
    - Auth: `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_BUCKET`, `AWS_DEFAULT_REGION`

## Authentication & Identity

**Auth Provider:** Laravel Fortify 1.34 (custom, no external OAuth)

- Implementation: Session/cookie-based (`config/auth.php` guard: `web`)
- Features enabled: login, registration, password reset, email verification, two-factor auth (TOTP)
- Two-factor: `TwoFactorAuthenticatable` trait on `app/Models/User.php`
- Views: Inertia-rendered React pages at `resources/js/pages/auth/`
- Rate limiting: configured in `app/Providers/FortifyServiceProvider.php`
- Provider: `app/Actions/Fortify/CreateNewUser.php`, `ResetUserPassword.php`

**Admin Auth:** Filament 5.0 — separate login at `/admin/login`

- Guard: `web` (shares same User model)
- No separate admin user table

**No external OAuth providers** (no Socialite, no Auth0, no Clerk)

## Monitoring & Observability

**Error Tracking:**

- Not detected — no Sentry, Bugsnag, Flare, or similar SDK present

**Logging:**

- Laravel Monolog — `LOG_CHANNEL=stack` → `single` by default
- Dev: `fruitcake/laravel-debugbar` 4.1 — in-browser debug panel (dev only)
- Dev: `laravel/pail` 1.2.5 — live log tail in terminal (dev only)
- Log files: `storage/logs/`

**Performance:**

- No APM configured (no Telescope, no Pulse, no Blackfire)

## CI/CD & Deployment

**Hosting:**

- Not specified — no deployment scripts, Dockerfiles, or platform configs detected

**CI Pipeline:**

- Not detected — no `.github/workflows/`, no `.gitlab-ci.yml`

**Docker:**

- Laravel Sail 1.53 available but no `docker-compose.yml` in project root detected

## Wayfinder (Route Generation)

**Tool:** `laravel/wayfinder` + `@laravel/vite-plugin-wayfinder`

- Server: generates TypeScript types from PHP routes and controller actions
- Client: auto-generated files output to `resources/js/actions/` and `resources/js/routes/` at build time
- Config in `vite.config.ts`: `wayfinder({ formVariants: true })`
- Used to call Laravel routes type-safely from React components

## Inertia SSR

**Server-Side Rendering:**

- Enabled: `config/inertia.php` → `ssr.enabled = true`
- SSR server URL: `http://127.0.0.1:13714`
- SSR bundle: `resources/js/ssr.tsx` (built via `vite build --ssr`)

## Admin Panel (Filament)

**Filament 5.0:**

- Panel path: `/admin`
- Discovery: auto-discovers Resources in `app/Filament/Resources/`, Pages in `app/Filament/Pages/`, Widgets in `app/Filament/Widgets/`
- Custom theme: `resources/css/filament/admin/theme.css`
- Real-time (Pusher/websocket): commented out in `config/filament.php` — **not active**

## Application Settings

**Spatie Laravel Settings 3.7:**

- Settings classes in `app/Settings/`
- `PricingSettings` — `global_adjustment`, `hourly_rate` (group: `pricing`)
- Stored in database settings table

## Environment Configuration

**Required env vars (minimal local setup):**

- `APP_KEY` — application encryption key
- `DB_CONNECTION` / `DB_DATABASE` — database
- `APP_URL` — application base URL

**Required for production email:**

- One of: `POSTMARK_API_KEY`, `RESEND_API_KEY`, or `AWS_ACCESS_KEY_ID` + `MAIL_MAILER` set accordingly

**Required for S3 storage:**

- `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_BUCKET`, `AWS_DEFAULT_REGION`

**Secrets location:**

- `.env` file (not committed — listed in `.gitignore`)
- `.env.example` committed with placeholder values

## Webhooks & Callbacks

**Incoming:** None detected — no webhook route handlers or signature verification code found

**Outgoing:** None detected — no HTTP client calls to external URLs in application code

---

_Integration audit: 2026-04-10_
