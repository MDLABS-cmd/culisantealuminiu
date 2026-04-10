# Coding Conventions

**Analysis Date:** 2026-04-10

## PHP Code Style

**Formatter:** Laravel Pint

- Preset: `laravel` (`pint.json`)
- Run: `./vendor/bin/pint`

**EditorConfig (`.editorconfig`):**

- Indent: 4 spaces (spaces, not tabs)
- Line endings: LF
- Charset: UTF-8
- Final newline: yes, trailing whitespace trimmed

## PHP Naming Patterns

**Files / Classes:**

- PascalCase for all PHP classes: `ProfileUpdateRequest`, `SchemaService`, `SchemaPriceTypeEnum`
- Suffix signals role: `*Controller`, `*Service`, `*Request`, `*Enum`, `*Factory`

**Methods:**

- camelCase: `getForSystem()`, `recalculateRow()`, `scopeActive()`
- Controller methods follow REST naming: `edit`, `update`, `destroy`, `store`, `index`
- Scope methods prefixed with `scope`: `scopeActive($query)`, `scopeStatus($query, ...)`

**Variables:**

- camelCase: `$systemId`, `$workingHours`, `$userId`

**Routes / Views:**

- Kebab-case route names: `profile.edit`, `two-factor.login`
- Inertia view strings use slash-separated kebab-case: `'settings/profile'`, `'settings/security'`

## PHP Model Patterns

- Models use PHP 8.x attribute syntax for `$fillable` and `$hidden`:
    ```php
    #[Fillable(['name', 'is_custom', 'active', 'order'])]
    class System extends Model
    ```
- Casts declared via `protected $casts = [...]` array property (or `protected function casts(): array` for User model — both patterns present)
- Enums backed by strings (`SchemaPriceTypeEnum: string`), with a static `options(): array` helper
- Enum casts in models: `'price_type' => SchemaPriceTypeEnum::class`
- Traits live in `app/Concerns/` with the `HasFiles`, `PasswordValidationRules`, `ProfileValidationRules` pattern
- Relationships use explicit return type declarations: `public function system(): BelongsTo`

**Example model:**

```php
// app/Models/Schema.php
#[Fillable(['system_id', 'material_id', 'name', 'price_type', 'order', 'active'])]
class Schema extends Model
{
    use HasFactory, HasFiles;

    protected $casts = [
        'price_type' => SchemaPriceTypeEnum::class,
        'active' => 'boolean',
    ];

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
```

## PHP Controller Patterns

- Controllers extend `App\Http\Controllers\Controller`
- Return types always declared: `Response`, `RedirectResponse`, `JsonResponse`
- Use `Inertia::render('page/path', [...props])` for Inertia responses
- Use `to_route('route.name')` for redirects (not `redirect()->route()`)
- Type-hinted FormRequest parameters for validation
- PHPDoc blocks on public methods that need brief description

**Example controller method:**

```php
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $request->user()->fill($request->validated());
    $request->user()->save();

    return to_route('profile.edit');
}
```

## PHP Service Patterns

- Services are plain PHP classes (`app/Services/`)
- No interface binding — injected or instantiated directly
- Methods have typed parameters and return types where possible
- PHPDoc `@return` used for generic collection returns: `@return Collection<int, System>`
- Short-circuit early returns for null/empty guards:
    ```php
    if (!$systemId) {
        return [];
    }
    ```

## PHP Form Request Patterns

- All validation through FormRequest classes (`app/Http/Requests/`)
- Rules extracted to Concern traits (`app/Concerns/ProfileValidationRules`, `PasswordValidationRules`)
- `rules()` delegates to trait methods: `return $this->profileRules($this->user()->id)`
- No `authorize()` overrides shown — defaults to `true`

## PHP Enums

- Backed string enums in `app/Enums/` with `Enum` suffix
- Always include `options(): array` static helper for Filament/form use
- Cast in models using native enum class binding

## TypeScript Naming Patterns

**Files:**

- React components: `kebab-case.tsx` (e.g., `app-sidebar.tsx`, `nav-user.tsx`)
- Hooks: `use-kebab-case.ts` or `use-kebab-case.tsx` (e.g., `use-clipboard.ts`, `use-appearance.tsx`)
- Type files: kebab-case domain name (e.g., `auth.ts`, `models.ts`, `navigation.ts`)
- Pages mirror Inertia view strings: `pages/settings/profile.tsx`

**Functions / Variables:**

- camelCase: `fetchQrCode`, `hasSetupData`, `mainNavItems`
- Hook names with `use` prefix: `useClipboard`, `useAppearance`, `useTwoFactorAuth`

**Types / Interfaces:**

- PascalCase: `User`, `BaseModel`, `NavItem`, `BreadcrumbItem`
- Return types always declared on hooks: `UseTwoFactorAuthReturn`, `UseClipboardReturn`
- `export type` (not `export interface`) — enforced by ESLint `consistent-type-imports`

## TypeScript Import Organization

**Order enforced by ESLint `import/order`:**

1. Builtin (node)
2. External packages (`react`, `@inertiajs/react`, `lucide-react`)
3. Internal path-aliased imports (`@/components/...`, `@/routes/...`, `@/types`)
4. Parent/sibling relative imports (rare)

**Alphabetized within groups** (ESLint enforced).

**Type imports separate from value imports:**

```ts
import { useState } from 'react';
import { qrCode, recoveryCodes, secretKey } from '@/routes/two-factor';
import type { TwoFactorSecretKey, TwoFactorSetupData } from '@/types';
```

**Path Aliases (tsconfig / vite):**

- `@/` → `resources/js/`

## TypeScript Type Conventions

- All model types extend `BaseModel` (`id: number`, `created_at: string`, `updated_at: string`)
- Types live in `resources/js/types/` split by domain
- Barrel file `resources/js/types/index.ts` re-exports all with `export type *`
- Shared page props extended via module augmentation in `resources/js/types/global.d.ts`:
    ```ts
    declare module '@inertiajs/core' {
        export interface InertiaConfig {
            sharedPageProps: { name: string; auth: Auth; sidebarOpen: boolean; ... };
        }
    }
    ```

## React Component Patterns

**Pages** (`resources/js/pages/`): default export, function named after the page:

```tsx
export default function Profile({ mustVerifyEmail, status }: Props) { ... }
```

**UI components** (`resources/js/components/ui/`): named exports, use `cva()` for variants:

```tsx
const buttonVariants = cva('base-classes', { variants: { variant: {...}, size: {...} } });
function Button({ className, variant, size, ...props }) { ... }
export { Button, buttonVariants }
```

**Layout components** (`resources/js/components/`): named exports for composable components, default for layouts.

**Prop types:** Inline object type for single-use props; named `type Props` for pages:

```tsx
type Props = { status?: string; canResetPassword: boolean; };
export default function Login({ status, canResetPassword }: Props) { ... }
```

## React Hook Patterns

- Hooks export a named return type and a named function:
    ```ts
    export type UseClipboardReturn = [CopiedValue, CopyFn];
    export function useClipboard(): UseClipboardReturn { ... }
    ```
- Constants exported alongside hooks when related (e.g., `export const OTP_MAX_LENGTH = 6`)
- Async operations use try/catch with state error accumulation:
    ```ts
    const [errors, setErrors] = useState<string[]>([]);
    // in catch: setErrors((prev) => [...prev, 'message'])
    ```

## Formatting Rules (Prettier `.prettierrc`)

- `semi: true` (semicolons required)
- `singleQuote: true`
- `tabWidth: 4`
- `printWidth: 80`
- `prettier-plugin-tailwindcss` auto-sorts Tailwind classes
- Tailwind sort applies to `clsx()`, `cn()`, and `cva()` calls

## Linting Rules (ESLint `eslint.config.js`)

- `@typescript-eslint/no-explicit-any`: off (any permitted)
- `@typescript-eslint/consistent-type-imports`: error — always use separate `import type`
- `import/order`: error — enforces group ordering + alphabetization
- `@stylistic/padding-line-between-statements`: blank lines required before/after all control statements (`if`, `return`, `for`, `while`, `try`, etc.)
- `curly: all` — always use braces for control blocks
- `@stylistic/brace-style: 1tbs` — opening brace on same line

**Ignored from lint:** `resources/js/actions/**`, `resources/js/components/ui/*`, `resources/js/routes/**`, `resources/js/wayfinder/**` (generated files)

## Utility Helpers

**`cn()` for conditional classes** (`resources/js/lib/utils.ts`):

```ts
import { cn } from '@/lib/utils';
// Usage:
className={cn('base-classes', conditionalClass && 'extra-class', className)}
```

**`toUrl()` for Inertia href normalization** (`resources/js/lib/utils.ts`):

```ts
export function toUrl(url: NonNullable<InertiaLinkProps['href']>): string { ... }
```

## Comments

**PHP:**

- PHPDoc on public methods that need explanation (controller methods, complex service methods)
- Single-line `// Scopes` section comments within models to group scope methods
- No inline `//` comments on trivial code

**TypeScript:**

- External credit comments for adapted utilities: `// Credit: https://...`
- No JSDoc in component files

---

_Convention analysis: 2026-04-10_
