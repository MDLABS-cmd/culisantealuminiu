import { usePage } from '@inertiajs/react';
import { AccesorySelector } from '@/components/configurator/accesory-selector';
import { ColorSelector } from '@/components/configurator/color-selector';
import { DimensionSelector } from '@/components/configurator/dimension-selector';
import { SchemaSelector } from '@/components/configurator/schema-selector';
import { Section } from '@/components/configurator/section';
import type { ConfiguratorState } from '@/types';
import { CustomOptionsList } from './custom-options-list';

type ConfiguratorOptionsSectionsProps = {
    state: ConfiguratorState;
    onSchemaSelect: (schemaId: number) => void;
    onToggleAccesory: (accesoryId: number) => void;
    onColorSelect: (categoryId: number, colorId: number | null) => void;
    onRetrySchemaOptions: (schemaId: number) => void;
};

export function ConfiguratorOptionsSections({
    state,
    onSchemaSelect,
    onToggleAccesory,
    onColorSelect,
    onRetrySchemaOptions,
}: ConfiguratorOptionsSectionsProps) {
    const page = usePage();
    const { activeCustomOptions } = page.props;

    return (
        <div className="space-y-6">
            <Section title="Alege schema" titleClassName="text-center">
                <SchemaSelector
                    schemas={state.schemas}
                    selectedSchemaId={state.selectedSchemaId}
                    loading={state.loadingSchemas}
                    onSelect={onSchemaSelect}
                />
            </Section>

            <Section
                title="Dimensiuni"
                description="Selectați dimensiunea de deschidere care corespunde configurației dorite a produsului."
            >
                <DimensionSelector />
            </Section>

            <Section
                title="Accesorii"
                description="Selectați opțiunile de accesorii pentru această configurație."
            >
                <div className="mt-4 flex flex-col gap-6 xl:flex-row">
                    <div className="min-w-0 flex-1">
                        <h3 className="text-sm font-semibold text-[#111827]">
                            Accesorii
                        </h3>
                        <AccesorySelector
                            accesories={state.options?.accesories ?? []}
                            selectedAccesoryIds={state.selectedAccesoryIds}
                            loading={state.loadingOptions}
                            onToggle={onToggleAccesory}
                        />
                    </div>
                </div>
            </Section>

            <Section title="Culori">
                <ColorSelector
                    categories={state.options?.colorCategories ?? []}
                    selectedColorIdsByCategory={
                        state.selectedColorIdsByCategory
                    }
                    loading={state.loadingOptions}
                    onSelect={onColorSelect}
                />

                {state.optionsError && (
                    <div className="mt-4 rounded-[18px] border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <p>{state.optionsError}</p>
                        {state.selectedSchemaId && (
                            <button
                                type="button"
                                className="mt-3 rounded-full border border-red-300 px-3 py-1.5 text-xs font-medium"
                                onClick={() => {
                                    if (state.selectedSchemaId) {
                                        onRetrySchemaOptions(
                                            state.selectedSchemaId,
                                        );
                                    }
                                }}
                            >
                                Retry
                            </button>
                        )}
                    </div>
                )}
            </Section>
            <Section title="Opțiuni personalizate">
                <CustomOptionsList customOptions={activeCustomOptions} />
            </Section>
        </div>
    );
}
