import { Head, usePage } from '@inertiajs/react';
import { useCallback, useEffect, useMemo } from 'react';
import { ConfigurationSummary } from '@/components/configurator/configuration-summary';
import { ConfiguratorOptionsSections } from '@/components/configurator/configurator-options-sections';
import ConfiguratorOrderForm from '@/components/configurator/configurator-order-form';
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
        hasCompletedRequiredSelections,
        setSystems,
        resetForSystemChange,
        resetForSchemaChange,
        setSchemas,
        setLoadingSchemas,
        setLoadingOptions,
        setOptions,
        setOptionsError,
        setSelectedSystem,
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
                        'Nu am putut încărca configurația schemei. Vă rugăm să încercați din nou.',
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
            {!hasCompletedRequiredSelections ? (
                <ConfiguratorOptionsSections
                    state={state}
                    onSchemaSelect={handleSchemaSelect}
                    onHandleSelect={selectHandle}
                    onToggleAccesory={toggleAccesory}
                    onColorSelect={selectColor}
                    onRetrySchemaOptions={loadSchemaOptions}
                />
            ) : (
                <ConfiguratorOrderForm />
            )}

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
