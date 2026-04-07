---
status: awaiting_human_verify
trigger: 'Investigate issue: pricing-loading-indicator-stuck'
created: 2026-04-07T00:00:00Z
updated: 2026-04-07T10:46:10+03:00
---

## Current Focus

hypothesis: wire:target="updatedSelectedSchema" is invalid for this interaction path; the real request target is the model update on selectedSchema.
test: Human verification on pricing page interaction flow with updated wire:target.
expecting: After selecting system and schema, loader appears only during request and disappears when table data loads.
next_action: user verifies in browser and reports outcome

## Symptoms

expected: Loading indicator should only appear during actual loading transitions and disappear once data load completes.
actual: Spinner is visible by default even with no selected system; after selecting both system and schema it remains stuck.
errors: none reported.
reproduction: Open pricing page, observe spinner; select system and schema, spinner still visible.
started: not provided.

## Eliminated

## Evidence

- timestamp: 2026-04-07T10:24:46.1575818+03:00
  checked: debug knowledge base
  found: .planning/debug/knowledge-base.md does not exist
  implication: proceed with fresh hypothesis generation from code evidence

- timestamp: 2026-04-07T10:29:00.8074557+03:00
  checked: Pricing page and related blade/components
  found: loading indicator uses wire:loading.delay.flex with wire:target="selectedSystem,selectedSchema"; actual heavy load occurs in updatedSelectedSchema() which loads material and rows
  implication: indicator can track non-table property synchronization and become visible outside intended transition window

- timestamp: 2026-04-07T10:30:38.6373658+03:00
  checked: syntax validation for updated pricing blade
  found: php -l reports no syntax errors
  implication: blade fix is structurally valid and ready for behavioral verification

- timestamp: 2026-04-07T10:41:00+03:00
  checked: human verification checkpoint response
  found: issue persists after selecting both system and schema; user suspects wire:target mismatch
  implication: previous hypothesis is not fully resolved; loading target behavior must be re-tested and corrected

- timestamp: 2026-04-07T10:43:20+03:00
  checked: pricing blade + page class + selector component wiring
  found: selector uses wire:model.live on selectedSchema, but loading indicator targets updatedSelectedSchema lifecycle method name
  implication: loading scope is likely not bound to the actual property update request and can remain active unexpectedly

- timestamp: 2026-04-07T10:44:40+03:00
  checked: pricing blade loading indicator wiring
  found: wire:target changed from updatedSelectedSchema to selectedSchema
  implication: loading indicator now targets the real property update request emitted by the schema selector

- timestamp: 2026-04-07T10:46:10+03:00
  checked: working tree diff for pricing blade
  found: updated loader target persists in file as wire:target="selectedSchema"
  implication: fix is present in source and ready for real browser verification

## Resolution

root_cause: Loading indicator target was scoped to generic property updates instead of the actual schema table-load method, so it could remain visible during unrelated or prolonged Livewire property synchronization.
fix: Restrict indicator rendering to valid selection state and retarget wire:loading to selectedSchema.
verification: Static verification confirms wire:target now points to selectedSchema; behavior requires in-browser confirmation on pricing page interaction steps.
files_changed: [resources/views/filament/pages/pricing.blade.php]
