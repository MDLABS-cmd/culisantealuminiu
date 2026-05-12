import type {
    ConfiguratorSchemaOptionsPayload,
    ConfiguratorSummary,
} from '@/types';

type BuildSummaryInput = {
    options: ConfiguratorSchemaOptionsPayload | null;
    selectedDimensionId: number | null;
    selectedAccesoryIds: number[];
};

const toNumber = (value: number | string | null | undefined): number => {
    if (typeof value === 'number') {
        return value;
    }

    if (typeof value === 'string') {
        const parsed = Number.parseFloat(value);

        return Number.isNaN(parsed) ? 0 : parsed;
    }

    return 0;
};

export const emptySummary: ConfiguratorSummary = {
    basePrice: 0,
    accessoriesTotal: 0,
    total: 0,
};

export function buildConfiguratorSummary({
    options,
    selectedDimensionId,
    selectedAccesoryIds,
}: BuildSummaryInput): ConfiguratorSummary {
    if (!options) {
        return emptySummary;
    }

    const selectedDimension = options.dimensions.find(
        (dimension) => dimension.id === selectedDimensionId,
    );
    const basePrice = toNumber(
        selectedDimension?.pricing?.price_without_vat ?? 0,
    );

    const accessoriesTotal = options.accesories
        .filter((accesory) => selectedAccesoryIds.includes(accesory.id))
        .reduce((carry, accesory) => carry + toNumber(accesory.price), 0);

    return {
        basePrice,
        accessoriesTotal,
        total: basePrice + accessoriesTotal,
    };
}
