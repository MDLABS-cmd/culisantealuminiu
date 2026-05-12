import { useEffect, useMemo, useState } from 'react';
import { useConfigurator } from '@/hooks/use-configurator';
import type { DimensionWithPricing } from '@/types';

type UseDimensionSelectorParams = {
    dimensions: DimensionWithPricing[];
};

const findNearestValue = (values: number[], target: number) =>
    values.reduce((best, current) => {
        const bestDistance = Math.abs(best - target);
        const currentDistance = Math.abs(current - target);

        return currentDistance < bestDistance ? current : best;
    }, values[0]);

const findRoundedDimension = (
    dimensions: DimensionWithPricing[],
    width: number,
    height: number,
) => {
    const uniqueWidths = [
        ...new Set(dimensions.map((dimension) => dimension.width)),
    ];
    const uniqueHeights = [
        ...new Set(dimensions.map((dimension) => dimension.height)),
    ];

    const roundedWidth = findNearestValue(uniqueWidths, width);
    const roundedHeight = findNearestValue(uniqueHeights, height);

    const exactRoundedMatch = dimensions.find(
        (dimension) =>
            dimension.width === roundedWidth &&
            dimension.height === roundedHeight,
    );

    if (exactRoundedMatch) {
        return exactRoundedMatch;
    }

    return dimensions.reduce<DimensionWithPricing | null>((best, current) => {
        const bestDistance =
            best === null
                ? Number.POSITIVE_INFINITY
                : Math.hypot(
                      best.width - roundedWidth,
                      best.height - roundedHeight,
                  );
        const currentDistance = Math.hypot(
            current.width - roundedWidth,
            current.height - roundedHeight,
        );

        return currentDistance < bestDistance ? current : best;
    }, null);
};

export function useDimensionSelector({
    dimensions,
}: UseDimensionSelectorParams) {
    const {
        state: { selectedDimensionId },
        selectDimension,
    } = useConfigurator();
    const [useDimensionList, setUseDimensionList] = useState(false);
    const [manualWidth, setManualWidth] = useState('');
    const [manualHeight, setManualHeight] = useState('');

    const selectedDimension = useMemo(
        () =>
            dimensions.find(
                (dimension) => dimension.id === selectedDimensionId,
            ) ?? null,
        [dimensions, selectedDimensionId],
    );

    const matchedDimension = useMemo(() => {
        const width = Number.parseFloat(manualWidth);
        const height = Number.parseFloat(manualHeight);

        if (!Number.isFinite(width) || !Number.isFinite(height)) {
            return null;
        }

        if (width <= 0 || height <= 0 || dimensions.length === 0) {
            return null;
        }

        return findRoundedDimension(dimensions, width, height);
    }, [dimensions, manualHeight, manualWidth]);

    useEffect(() => {
        if (!useDimensionList && matchedDimension) {
            selectDimension(matchedDimension.id);
        }
    }, [matchedDimension, selectDimension, useDimensionList]);

    const handleModeChange = (checked: boolean) => {
        if (!checked && selectedDimension) {
            setManualWidth(String(selectedDimension.width));
            setManualHeight(String(selectedDimension.height));
        }

        setUseDimensionList(checked);
    };

    return {
        useDimensionList,
        manualWidth,
        manualHeight,
        matchedDimension,
        setManualWidth,
        setManualHeight,
        handleModeChange,
    };
}
