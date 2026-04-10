# Testing Patterns

**Analysis Date:** 2026-04-10

## Test Framework

**Runner:** Pest PHP

- Config: `phpunit.xml` (PHPUnit backend, Pest front-end)
- Bootstrap: `vendor/autoload.php`
- Bootstrap file: `tests/Pest.php`

**Assertion Style:** Pest `expect()` API

**Run Commands:**

```bash
php artisan test                  # Run all tests
php artisan test --filter "name"  # Filter by test name
./vendor/bin/pest                 # Run directly via Pest
./vendor/bin/pest --coverage      # With coverage
```

## Test Suites

Defined in `phpunit.xml`:
| Suite | Directory |
|-------|-----------|
| Unit | `tests/Unit/` |
| Feature | `tests/Feature/` |

## Test Environment (`phpunit.xml`)

All tests run with:

- `APP_ENV=testing`
- `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:` (in-memory SQLite)
- `CACHE_STORE=array`
- `MAIL_MAILER=array`
- `QUEUE_CONNECTION=sync`
- `SESSION_DRIVER=array`
- `BCRYPT_ROUNDS=4`
- `PULSE_ENABLED=false`, `TELESCOPE_ENABLED=false`, `NIGHTWATCH_ENABLED=false`

## Database Refresh

`RefreshDatabase` applied globally to **all Feature tests** via `Pest.php`:

```php
// tests/Pest.php
pest()->extend(TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');
```

Unit tests do NOT get `RefreshDatabase` — they should not touch the database.

## Base Test Case

`tests/TestCase.php` extends `Illuminate\Foundation\Testing\TestCase` with one custom helper:

```php
protected function skipUnlessFortifyFeature(string $feature, ?string $message = null): void
{
    if (! Features::enabled($feature)) {
        $this->markTestSkipped($message ?? "Fortify feature [{$feature}] is not enabled.");
    }
}
```

Use `$this->skipUnlessFortifyFeature(Features::twoFactorAuthentication())` at the top of any test that requires a Fortify feature flag.

## Test File Organization

```
tests/
├── Pest.php                          # Global setup: extends TestCase, RefreshDatabase for Feature
├── TestCase.php                      # Base class with custom helpers
├── Unit/
│   └── ExampleTest.php
└── Feature/
    ├── DashboardTest.php
    ├── ExampleTest.php
    ├── Auth/
    │   ├── AuthenticationTest.php
    │   ├── EmailVerificationTest.php
    │   ├── PasswordConfirmationTest.php
    │   ├── PasswordResetTest.php
    │   ├── RegistrationTest.php
    │   ├── TwoFactorChallengeTest.php
    │   └── VerificationNotificationTest.php
    └── Settings/
        ├── ProfileUpdateTest.php
        └── SecurityTest.php
```

**Placement rule:** Feature tests mirror the controller structure. `Settings\ProfileUpdateTest` tests `Settings\ProfileController`.

## Test Structure

**Every test is a top-level `test()` call** (no `describe()` grouping used):

```php
test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch(route('profile.update'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('profile.edit'));

    expect($user->refresh()->name)->toBe('Test User');
    expect($user->refresh()->email)->toBe('test@example.com');
});
```

**Pattern:**

1. Arrange: create factory model(s)
2. Act: perform HTTP request via `$this->actingAs($user)->method(route(...), [data])`
3. Assert: chain HTTP assertions then `expect()` assertions on refreshed models

## HTTP Assertions

Use standard Laravel HTTP test assertions chained on the response:

```php
$response->assertOk();
$response->assertRedirect(route('route.name'));
$response->assertSessionHasNoErrors();
$response->assertSessionHas('login.id', $user->id);
```

## Inertia Page Assertions

Use `Inertia\Testing\AssertableInertia` for Inertia response validation:

```php
use Inertia\Testing\AssertableInertia as Assert;

$this->actingAs($user)
    ->get(route('security.edit'))
    ->assertInertia(fn (Assert $page) => $page
        ->component('settings/security')
        ->where('canManageTwoFactor', true)
        ->where('twoFactorEnabled', false)
        ->missing('requiresConfirmation'),
    );
```

- Use `->component('page/path')` to assert the rendered Inertia component
- Use `->where('prop', value)` to assert prop values
- Use `->missing('prop')` to assert props are absent

## Model Assertions

After HTTP actions, reload the model and assert with `expect()`:

```php
expect($user->fresh())->toBeNull();          // deleted
expect($user->refresh()->name)->toBe('...');  // updated field
expect($user->refresh()->email_verified_at)->toBeNull();
expect($user->refresh()->email_verified_at)->not->toBeNull();
```

Use `->fresh()` when checking deletion (returns null), `->refresh()` for updated attributes.

## Authentication in Tests

```php
// Act as authenticated user
$this->actingAs($user)->get(route('dashboard'));

// Assert auth state
$this->assertAuthenticated();
$this->assertGuest();

// With session state
$this->actingAs($user)
    ->withSession(['auth.password_confirmed_at' => time()])
    ->get(route('security.edit'));
```

## Test Data / Factories

**Only `User::factory()` shown in test suite.** Other models likely have factories (`SystemFactory`, `SchemaFactory` referenced in model `@use` annotations).

```php
$user = User::factory()->create();
```

- Use `->create()` to persist to the in-memory database
- Use `->make()` for non-persisted instances (Unit tests)
- Use `->forceFill([...])->save()` to set normally protected attributes (e.g., 2FA fields)

## Mocking

**No mock examples found in existing tests.** The codebase tests via HTTP (integration-style Feature tests) rather than unit-mocking services. `RateLimiter` imported in `AuthenticationTest` suggests facade stubs may be used:

```php
use Illuminate\Support\Facades\RateLimiter;
```

When mocking facades, use:

```php
RateLimiter::shouldReceive('hit')->once();
// or
RateLimiter::partialMock();
```

## Custom Expect Extensions

Defined in `tests/Pest.php` (placeholder only):

```php
expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});
```

Add domain-specific expectations here to reduce repetition across tests.

## Global Test Helpers

Functions defined in `tests/Pest.php` are available globally in all tests:

```php
function something()
{
    // define shared setup helpers here
}
```

Currently unused — the `something()` function is a scaffold placeholder.

## Coverage

**Requirements:** None configured (no `--min-coverage` or threshold in `phpunit.xml`).

**Source coverage scope:** `app/` directory (configured in `phpunit.xml` `<source>`).

**View coverage:**

```bash
php artisan test --coverage
./vendor/bin/pest --coverage --coverage-html=coverage/
```

## Frontend Testing

**No frontend test setup detected.** No Vitest, Jest, or Playwright config present. Frontend (React/TypeScript) has no automated tests.

---

_Testing analysis: 2026-04-10_
