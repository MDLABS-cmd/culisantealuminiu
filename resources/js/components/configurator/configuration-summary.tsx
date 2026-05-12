import { useConfigurator } from '@/hooks/use-configurator';
import type {
    Color,
    ColorCategoryWithColors,
    ConfiguratorSchemaOptionsPayload,
    ConfiguratorSummary,
    System,
} from '@/types';

type ConfigurationSummaryProps = {
    systems: System[];
    selectedSystemId: number | null;
    selectedSchemaId: number | null;
    selectedDimensionId: number | null;
    selectedAccesoryIds: number[];
    selectedColorIdsByCategory: Record<number, number | null>;
    options: ConfiguratorSchemaOptionsPayload | null;
    summary: ConfiguratorSummary;
};

export function ConfigurationSummary({
    systems,
    selectedSystemId,
    selectedSchemaId,
    selectedDimensionId,
    selectedAccesoryIds,
    selectedColorIdsByCategory,
    options,
    summary,
}: ConfigurationSummaryProps) {
    const { hasCompletedRequiredSelections, markSelectionCompleted } =
        useConfigurator();
    const selectedSystem = systems.find((item) => item.id === selectedSystemId);
    const selectedSchema = selectedSchemaId ? options?.schema : null;
    const selectedDimension = options?.dimensions.find(
        (item) => item.id === selectedDimensionId,
    );
    const selectedAccesories =
        options?.accesories.filter((item) =>
            selectedAccesoryIds.includes(item.id),
        ) ?? [];
    const selectedColors =
        options?.colorCategories
            .map((category) => {
                const selectedColorId = selectedColorIdsByCategory[category.id];

                if (!selectedColorId) {
                    return null;
                }

                const color = category.colors.find(
                    (item) => item.id === selectedColorId,
                );

                if (!color) {
                    return null;
                }

                return { category, color };
            })
            .filter(
                (
                    item,
                ): item is {
                    category: ColorCategoryWithColors;
                    color: Color;
                } => Boolean(item),
            ) ?? [];

    const selectedDimensionLabel = selectedDimension
        ? `${selectedDimension.width} x ${selectedDimension.height} mm`
        : 'Nu au fost selectate';

    const selectedAccessoriesLabel =
        selectedAccesories.length > 0
            ? selectedAccesories.map((item) => item.name).join(', ')
            : 'Nu au fost selectate';

    const selectedColorLabel =
        selectedColors.length > 0
            ? selectedColors
                  .map(
                      ({ category, color }) =>
                          `${category.name}: ${color.name}`,
                  )
                  .join(', ')
            : 'Nu au fost selectate';

    const selectedSchemaLabel = selectedSchema?.name ?? 'Nu au fost selectate';
    const selectedSystemLabel = selectedSystem?.name ?? 'Nu au fost selectate';

    const canContinue = Boolean(
        selectedSystem && selectedSchema && selectedDimension,
    );

    const handleSummaryAction = () => {
        if (!canContinue) {
            return;
        }

        if (!hasCompletedRequiredSelections) {
            markSelectionCompleted();
        }
    };

    return (
        <aside className="rounded-[20px] bg-white p-6 md:p-6 lg:sticky lg:top-6">
            <p className="poppins-bold text-[16px] leading-normal text-[#111827] uppercase">
                Rezumat configurație
            </p>

            <dl className="poppins-regular mt-6 space-y-4 text-[14px] leading-normal">
                <div className="flex items-center gap-2">
                    <dt className="text-[#6b7280]">Sistem</dt>
                    <dd className="text-[#111827]">{selectedSystemLabel}</dd>
                </div>
                <div className="flex items-center gap-2">
                    <dt className="text-[#6b7280]">Schemă</dt>
                    <dd className="text-[#111827]">{selectedSchemaLabel}</dd>
                </div>
                <div className="flex flex-col gap-2">
                    <div className="flex items-center gap-2">
                        <dt className="text-[#6b7280]">Dimensiune comandată</dt>
                        <dd className="text-[#111827]">
                            {selectedDimensionLabel}
                        </dd>
                    </div>
                    <dd className="text-[12px] text-[#6b7280]">
                        Dimensiune tarifată:{' '}
                        {selectedDimension
                            ? `${selectedDimension.width} x ${selectedDimension.height} mm`
                            : 'Nespecificată'}
                    </dd>
                </div>
                <div className="flex items-center gap-2">
                    <dt className="text-[#6b7280]">Accesorii</dt>
                    <dd className="text-[#111827]">
                        {selectedAccessoriesLabel}
                    </dd>
                </div>
                <div className="flex items-center gap-2">
                    <dt className="text-[#6b7280]">Culoare</dt>
                    <dd className="text-[#111827]">{selectedColorLabel}</dd>
                </div>
            </dl>

            {/* <div className="mt-8">
                <p className="poppins-medium text-[16px] leading-normal text-[#111827]">
                    Oferta personalizata
                </p>
                <p className="poppins-regular mt-6 text-[14px] leading-normal text-[#6b7280]">
                    Cererea ta a fost inregistrata pentru : {customOfferLabel}
                </p>
            </div> */}

            <div className="mt-8 h-px w-full bg-[#6b7280]" />

            <div className="poppins-regular mt-6 flex w-full flex-col items-end gap-2 leading-normal text-[#111827]">
                <p className="text-[12px]">PREȚ FĂRĂ TVA</p>
                <p className="text-[36px] leading-none">
                    {summary.total.toFixed(0)}€
                </p>
            </div>

            <button
                type="button"
                disabled={!canContinue}
                className="poppins-regular mt-8 w-full rounded-[14px] bg-[#111827] px-10 py-2 text-[14px] leading-normal text-white transition disabled:cursor-not-allowed disabled:opacity-50"
                onClick={handleSummaryAction}
            >
                Comandă acum
            </button>
        </aside>
    );
}
