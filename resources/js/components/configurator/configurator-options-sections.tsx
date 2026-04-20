import { AccesorySelector } from '@/components/configurator/accesory-selector';
import { ColorSelector } from '@/components/configurator/color-selector';
import { DimensionSelector } from '@/components/configurator/dimension-selector';
import { HandleSelector } from '@/components/configurator/handle-selector';
import { SchemaSelector } from '@/components/configurator/schema-selector';
import { Section } from '@/components/configurator/section';
import type { ConfiguratorState } from '@/types';

type ConfiguratorOptionsSectionsProps = {
    state: ConfiguratorState;
    onSchemaSelect: (schemaId: number) => void;
    onHandleSelect: (handleId: number | null) => void;
    onToggleAccesory: (accesoryId: number) => void;
    onColorSelect: (categoryId: number, colorId: number | null) => void;
    onRetrySchemaOptions: (schemaId: number) => void;
};

export function ConfiguratorOptionsSections({
    state,
    onSchemaSelect,
    onHandleSelect,
    onToggleAccesory,
    onColorSelect,
    onRetrySchemaOptions,
}: ConfiguratorOptionsSectionsProps) {
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
                title="Dimensions"
                description="Select the opening size that matches the desired product configuration."
            >
                <DimensionSelector />
            </Section>

            <Section
                title="Handles & Accessories"
                description="Select handle and accessory options for this configuration."
            >
                <div className="mt-4 flex flex-col gap-6 xl:flex-row">
                    <div className="min-w-0 flex-1">
                        <h3 className="text-sm font-semibold text-[#111827]">
                            Handle
                        </h3>
                        <HandleSelector
                            handles={state.options?.handles ?? []}
                            selectedHandleId={state.selectedHandleId}
                            loading={state.loadingOptions}
                            onSelect={onHandleSelect}
                        />
                    </div>

                    <div className="min-w-0 flex-1">
                        <h3 className="text-sm font-semibold text-[#111827]">
                            Accessories
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

            <Section
                title="Colors"
                description="Color categories are loaded from the selected system and shown as individual accordion groups."
            >
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
        </div>
    );
}
