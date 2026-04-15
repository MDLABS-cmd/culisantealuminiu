import { Head, usePage } from '@inertiajs/react';
import { useCallback, useEffect, useMemo } from 'react';
import { AccesorySelector } from '@/components/configurator/accesory-selector';
import { ColorSelector } from '@/components/configurator/color-selector';
import { ConfigurationSummary } from '@/components/configurator/configuration-summary';
import { DimensionSelector } from '@/components/configurator/dimension-selector';
import { HandleSelector } from '@/components/configurator/handle-selector';
import { SchemaSelector } from '@/components/configurator/schema-selector';
import { Section } from '@/components/configurator/section';
import { ConfiguratorProvider } from '@/contexts/configurator-context';
import { useConfigurator } from '@/hooks/use-configurator';
import ConfiguratorLayout from '@/layouts/configurator-layout';
import type {
    ConfiguratorSchemaListItem,
    ConfiguratorSchemaOptionsPayload,
    System,
} from '@/types';

type SchemaApiResponse = {
    data: ConfiguratorSchemaListItem[];
};

type SchemaOptionsApiResponse = {
    data: ConfiguratorSchemaOptionsPayload;
};

function normalizeSystems(input: unknown): System[] {
    if (!Array.isArray(input)) {
        return [];
    }

    return (input as System[]).filter(
        (system): system is System =>
            Boolean(system) &&
            typeof system.id === 'number' &&
            Number.isFinite(system.id),
    );
}

function ConfiguratorPageContent() {
    const page = usePage();
    const { activeSystems } = page.props;
    const systems = useMemo(
        () => normalizeSystems(activeSystems),
        [activeSystems],
    );
    const {
        state,
        summary,
        setSystems,
        resetForSystemChange,
        resetForSchemaChange,
        setSchemas,
        setLoadingSchemas,
        setLoadingOptions,
        setOptions,
        setOptionsError,
        setSelectedSystem,
        selectDimension,
        selectHandle,
        toggleAccesory,
        selectColor,
    } = useConfigurator();

    const loadSchemas = useCallback(
        (systemId: number) => {
            setLoadingSchemas(true);
            setSchemas([]);

            fetch(`/systems/${systemId}/schemas`)
                .then(
                    (response) => response.json() as Promise<SchemaApiResponse>,
                )
                .then((payload) => {
                    setSchemas(payload.data ?? []);
                })
                .catch(() => {
                    setSchemas([]);
                })
                .finally(() => {
                    setLoadingSchemas(false);
                });
        },
        [setLoadingSchemas, setSchemas],
    );

    const loadSchemaOptions = useCallback(
        (schemaId: number) => {
            resetForSchemaChange(schemaId);
            setLoadingOptions(true);
            setOptionsError(null);

            fetch(`/schemas/${schemaId}/configurator-options`)
                .then(
                    (response) =>
                        response.json() as Promise<SchemaOptionsApiResponse>,
                )
                .then((payload) => {
                    setOptions(payload.data ?? null);
                })
                .catch(() => {
                    setOptions(null);
                    setOptionsError(
                        'We could not load this schema configuration. Please try again.',
                    );
                })
                .finally(() => {
                    setLoadingOptions(false);
                });
        },
        [resetForSchemaChange, setLoadingOptions, setOptions, setOptionsError],
    );

    useEffect(() => {
        setSystems(systems);
    }, [setSystems, systems]);

    useEffect(() => {
        if (systems.length === 0) {
            return;
        }

        const params = new URLSearchParams(page.url.split('?')[1] ?? '');
        const systemFromQuery = Number(params.get('system'));
        const fallbackSystemId = systems[0]?.id ?? null;
        const nextSystemId =
            Number.isFinite(systemFromQuery) && systemFromQuery > 0
                ? systemFromQuery
                : fallbackSystemId;

        if (!nextSystemId) {
            return;
        }

        resetForSystemChange(nextSystemId);
        setSelectedSystem(nextSystemId);
        loadSchemas(nextSystemId);
    }, [
        loadSchemas,
        page.url,
        resetForSystemChange,
        setSelectedSystem,
        systems,
    ]);

    const handleSchemaSelect = (schemaId: number) => {
        loadSchemaOptions(schemaId);
    };

    return (
        <div className="grid gap-8 xl:grid-cols-[minmax(0,1fr)_400px] xl:items-start">
            <div className="space-y-6">
                <Section title="Alege schema" titleClassName="text-center">
                    <SchemaSelector
                        schemas={state.schemas}
                        selectedSchemaId={state.selectedSchemaId}
                        loading={state.loadingSchemas}
                        onSelect={handleSchemaSelect}
                    />
                </Section>

                <Section
                    title="Dimensions"
                    description="Select the opening size that matches the desired product configuration."
                >
                    <DimensionSelector
                        dimensions={state.options?.dimensions ?? []}
                        selectedDimensionId={state.selectedDimensionId}
                        loading={state.loadingOptions}
                        onSelect={selectDimension}
                    />
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
                                onSelect={selectHandle}
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
                                onToggle={toggleAccesory}
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
                        onSelect={selectColor}
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
                                            loadSchemaOptions(
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

            <ConfigurationSummary
                systems={state.systems}
                selectedSystemId={state.selectedSystemId}
                selectedSchemaId={state.selectedSchemaId}
                selectedDimensionId={state.selectedDimensionId}
                selectedHandleId={state.selectedHandleId}
                selectedAccesoryIds={state.selectedAccesoryIds}
                selectedColorIdsByCategory={state.selectedColorIdsByCategory}
                options={state.options}
                summary={summary}
            />
        </div>
    );
}

export default function ConfiguratorPage() {
    return (
        <ConfiguratorLayout>
            <Head title="Configurator" />
            <ConfiguratorProvider>
                <ConfiguratorPageContent />
            </ConfiguratorProvider>
        </ConfiguratorLayout>
    );
}
