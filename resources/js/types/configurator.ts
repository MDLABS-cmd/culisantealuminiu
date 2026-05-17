import type {
    Accesory,
    ColorCategoryWithColors,
    DimensionWithPricing,
    Handle,
    Schema,
    System,
} from './models';

export type ConfiguratorSchemaListItem = Pick<
    Schema,
    'id' | 'name' | 'order'
> & {
    image_url?: string | null;
};

export type ConfiguratorSchemaOptionsPayload = {
    schema: Schema;
    dimensions: DimensionWithPricing[];
    accesories: Accesory[];
    handles: Handle[];
    colorCategories: ColorCategoryWithColors[];
};

export type ConfiguratorSummary = {
    basePrice: number;
    accessoriesTotal: number;
    total: number;
};

export type ConfiguratorState = {
    systems: System[];
    selectedSystemId: number | null;
    schemas: ConfiguratorSchemaListItem[];
    selectedSchemaId: number | null;
    options: ConfiguratorSchemaOptionsPayload | null;
    selectedDimensionId: number | null;
    selectedAccesoryIds: number[];
    selectedCustomOptionIds: number[];
    selectedColorIdsByCategory: Record<number, number | null>;
    loadingSchemas: boolean;
    loadingOptions: boolean;
    optionsError: string | null;
};

export type OrderState = {
    companyName: string | null;
    firstName: string;
    lastName: string;
    email: string;
    phone: string;
    address: string;
    observations: string | null;
    createAccount: boolean;
    password: string | null;
    confirmPassword: string | null;
};

export type ConfiguratorContextValue = {
    state: ConfiguratorState;
    orderState: OrderState;
    summary: ConfiguratorSummary;
    hasCompletedRequiredSelections: boolean;
    setSystems: (systems: System[]) => void;
    setSelectedSystem: (systemId: number | null) => void;
    setSchemas: (schemas: ConfiguratorSchemaListItem[]) => void;
    setSelectedSchema: (schemaId: number | null) => void;
    setOptions: (options: ConfiguratorSchemaOptionsPayload | null) => void;
    setLoadingSchemas: (isLoading: boolean) => void;
    setLoadingOptions: (isLoading: boolean) => void;
    setOptionsError: (error: string | null) => void;
    selectDimension: (dimensionId: number | null) => void;
    selectHandle: (handleId: number | null) => void;
    toggleAccesory: (accesoryId: number) => void;
    toggleCustomOption: (customOptionId: number) => void;
    selectColor: (categoryId: number, colorId: number | null) => void;
    setOrderState: (orderState: OrderState) => void;
    markSelectionCompleted: () => void;
    resetForSystemChange: (nextSystemId: number | null) => void;
    resetForSchemaChange: (nextSchemaId: number | null) => void;
};
