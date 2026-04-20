import {
    createContext,
    useCallback,
    useContext,
    useMemo,
    useState,
} from 'react';
import type { PropsWithChildren } from 'react';
import {
    buildConfiguratorSummary,
    emptySummary,
} from '@/lib/configurator-price';
import type {
    ConfiguratorContextValue,
    ConfiguratorSchemaListItem,
    ConfiguratorSchemaOptionsPayload,
    ConfiguratorState,
    OrderState,
    System,
} from '@/types';

const ConfiguratorContext = createContext<ConfiguratorContextValue | null>(
    null,
);

const initialState: ConfiguratorState = {
    systems: [],
    selectedSystemId: null,
    schemas: [],
    selectedSchemaId: null,
    options: null,
    selectedDimensionId: null,
    selectedHandleId: null,
    selectedAccesoryIds: [],
    selectedColorIdsByCategory: {},
    loadingSchemas: false,
    loadingOptions: false,
    optionsError: null,
};

const initialOrderState: OrderState = {
    companyName: null,
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    address: '',
    observations: null,
    createAccount: false,
    password: null,
    confirmPassword: null,
};

export function ConfiguratorProvider({ children }: PropsWithChildren) {
    const [state, setState] = useState<ConfiguratorState>(initialState);
    const [orderState, setOrderState] = useState<OrderState>(initialOrderState);
    const [hasCompletedRequiredSelections, setHasCompletedRequiredSelections] =
        useState(false);

    const resetDependentSelections = useCallback(
        (nextSchemaId: number | null, nextSystemId: number | null) => {
            setState((previous) => ({
                ...previous,
                selectedSystemId: nextSystemId,
                selectedSchemaId: nextSchemaId,
                options: null,
                selectedDimensionId: null,
                selectedHandleId: null,
                selectedAccesoryIds: [],
                selectedColorIdsByCategory: {},
                optionsError: null,
            }));
        },
        [],
    );

    const summary = useMemo(
        () =>
            buildConfiguratorSummary({
                options: state.options,
                selectedDimensionId: state.selectedDimensionId,
                selectedHandleId: state.selectedHandleId,
                selectedAccesoryIds: state.selectedAccesoryIds,
            }),
        [
            state.options,
            state.selectedDimensionId,
            state.selectedHandleId,
            state.selectedAccesoryIds,
        ],
    );

    const value = useMemo<ConfiguratorContextValue>(
        () => ({
            state,
            orderState,
            hasCompletedRequiredSelections,
            summary: state.options ? summary : emptySummary,
            setSystems: (systems: System[]) => {
                setState((previous) => ({ ...previous, systems }));
            },
            setSelectedSystem: (systemId: number | null) => {
                setState((previous) => ({
                    ...previous,
                    selectedSystemId: systemId,
                }));
            },
            setSchemas: (schemas: ConfiguratorSchemaListItem[]) => {
                setState((previous) => ({ ...previous, schemas }));
            },
            setSelectedSchema: (schemaId: number | null) => {
                setState((previous) => ({
                    ...previous,
                    selectedSchemaId: schemaId,
                }));
            },
            setOptions: (options: ConfiguratorSchemaOptionsPayload | null) => {
                setState((previous) => ({ ...previous, options }));
            },
            setLoadingSchemas: (isLoading: boolean) => {
                setState((previous) => ({
                    ...previous,
                    loadingSchemas: isLoading,
                }));
            },
            setLoadingOptions: (isLoading: boolean) => {
                setState((previous) => ({
                    ...previous,
                    loadingOptions: isLoading,
                }));
            },
            setOptionsError: (error: string | null) => {
                setState((previous) => ({ ...previous, optionsError: error }));
            },
            selectDimension: (dimensionId: number | null) => {
                setState((previous) => ({
                    ...previous,
                    selectedDimensionId: dimensionId,
                }));
            },
            selectHandle: (handleId: number | null) => {
                setState((previous) => ({
                    ...previous,
                    selectedHandleId: handleId,
                }));
            },
            toggleAccesory: (accesoryId: number) => {
                setState((previous) => {
                    const hasAccesory =
                        previous.selectedAccesoryIds.includes(accesoryId);

                    return {
                        ...previous,
                        selectedAccesoryIds: hasAccesory
                            ? previous.selectedAccesoryIds.filter(
                                  (id) => id !== accesoryId,
                              )
                            : [...previous.selectedAccesoryIds, accesoryId],
                    };
                });
            },
            selectColor: (categoryId: number, colorId: number | null) => {
                setState((previous) => ({
                    ...previous,
                    selectedColorIdsByCategory: {
                        ...previous.selectedColorIdsByCategory,
                        [categoryId]: colorId,
                    },
                }));
            },
            resetForSystemChange: (nextSystemId: number | null) => {
                resetDependentSelections(null, nextSystemId);

                setState((previous) => ({ ...previous, schemas: [] }));
            },
            resetForSchemaChange: (nextSchemaId: number | null) => {
                resetDependentSelections(nextSchemaId, state.selectedSystemId);
            },
            setOrderState: (orderState: OrderState) => {
                setOrderState(orderState);
            },
            markSelectionCompleted: () => {
                setHasCompletedRequiredSelections(true);
            },
        }),
        [
            resetDependentSelections,
            state,
            orderState,
            hasCompletedRequiredSelections,
            summary,
        ],
    );

    return (
        <ConfiguratorContext.Provider value={value}>
            {children}
        </ConfiguratorContext.Provider>
    );
}

export function useConfiguratorContext(): ConfiguratorContextValue {
    const context = useContext(ConfiguratorContext);

    if (!context) {
        throw new Error(
            'useConfiguratorContext must be used within ConfiguratorProvider',
        );
    }

    return context;
}
