<div class="flex gap-4">
    <div class="flex-1">
        <livewire:ui.form-select :key="'system-select'" wire:model.live="selectedSystem" :options="$this->getSystems()"
            placeholder="-- Select System --" />
    </div>

    <div class="flex-1">
        <livewire:ui.form-select :key="'schema-select-' . ($selectedSystem ?? 'none')" wire:model.live="selectedSchema" :options="$this->getSchemas()"
            placeholder="-- Select Schema --" :disabled="!$selectedSystem" />
    </div>
</div>
