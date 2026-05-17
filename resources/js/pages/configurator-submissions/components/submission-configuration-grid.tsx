import type { ConfiguratorSubmissionDetails } from '@/types';
import { formatCurrency, normalizeHex } from '../utils/formatters';
import { BulletRow } from './bullet-row';
import { ConfigCard } from './config-card';

type SubmissionConfigurationGridProps = {
    submission: ConfiguratorSubmissionDetails;
};

export function SubmissionConfigurationGrid({
    submission,
}: SubmissionConfigurationGridProps) {
    const accessories = submission.accessories;

    return (
        <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
            <ConfigCard title="Sistem, schema">
                <div className="flex w-full gap-4">
                    <div className="flex min-w-0 flex-1 flex-col gap-2">
                        <p className="text-base font-medium text-[#111827]">
                            Sistem
                        </p>
                        <div className="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                            <p className="text-sm text-[#111827]">
                                {submission.system?.name ?? '-'}
                            </p>
                        </div>
                    </div>
                    <div className="flex min-w-0 flex-1 flex-col gap-2">
                        <p className="text-base font-medium text-[#111827]">
                            Schema
                        </p>
                        <div className="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                            <p className="text-sm text-[#111827]">
                                {submission.schema?.name ?? '-'}
                            </p>
                        </div>
                    </div>
                </div>
            </ConfigCard>

            <ConfigCard title="Culoare">
                {submission.color ? (
                    <div className="flex flex-col items-start rounded-xl">
                        <div
                            className="h-36 w-44 rounded-xl"
                            style={{
                                backgroundColor: normalizeHex(
                                    submission.color.hex_code,
                                ),
                            }}
                        />
                        <div className="flex flex-col gap-0.5 px-2 pt-1 pb-2">
                            <p className="text-xs text-[#6b7280]">
                                {submission.color.code || ''}
                            </p>
                            <p className="text-sm text-[#111827]">
                                {submission.color.name}
                            </p>
                        </div>
                    </div>
                ) : (
                    <p className="text-sm text-[#6b7280]">-</p>
                )}
            </ConfigCard>

            <ConfigCard title="Dimensiuni">
                <div className="flex w-full gap-4">
                    <div className="flex min-w-0 flex-1 flex-col gap-2">
                        <p className="text-base font-medium text-[#111827]">
                            Inaltime
                        </p>
                        <div className="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                            <p className="text-sm text-[#111827]">
                                {submission.dimension
                                    ? `${submission.dimension.height} mm`
                                    : '-'}
                            </p>
                        </div>
                    </div>
                    <div className="flex min-w-0 flex-1 flex-col gap-2">
                        <p className="text-base font-medium text-[#111827]">
                            Latime
                        </p>
                        <div className="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                            <p className="text-sm text-[#111827]">
                                {submission.dimension
                                    ? `${submission.dimension.width} mm`
                                    : '-'}
                            </p>
                        </div>
                    </div>
                </div>
            </ConfigCard>

            <ConfigCard title="Accesorii">
                <div className="flex w-full flex-col gap-0.5">
                    {accessories.length > 0 ? (
                        accessories.map((accessoryRow) => (
                            <BulletRow
                                key={accessoryRow.id}
                                text={accessoryRow.accesory?.name ?? '-'}
                            />
                        ))
                    ) : (
                        <p className="text-sm text-[#6b7280]">
                            Nu au fost selectate accesorii.
                        </p>
                    )}
                </div>
            </ConfigCard>

            <ConfigCard title="Maner">
                <div className="flex w-full flex-col">
                    {submission.handle ? (
                        <BulletRow text={submission.handle.name} />
                    ) : (
                        <p className="text-sm text-[#6b7280]">-</p>
                    )}
                </div>
            </ConfigCard>

            <ConfigCard title="Optiune Custom">
                <div className="flex w-full flex-col">
                    {submission.customOption ? (
                        <BulletRow text={submission.customOption.name} />
                    ) : (
                        <p className="text-sm text-[#6b7280]">-</p>
                    )}
                </div>
            </ConfigCard>

            <ConfigCard title="Pret">
                <div className="flex w-full items-start gap-1">
                    <div className="flex flex-1 flex-col gap-0.5">
                        <BulletRow
                            text={`Dimensiune: ${
                                submission.dimension
                                    ? `${submission.dimension.width}x${submission.dimension.height}`
                                    : '-'
                            } (+${formatCurrency(submission.base_price)} EUR)`}
                        />

                        {accessories.map((accessoryRow) => (
                            <BulletRow
                                key={`price-${accessoryRow.id}`}
                                text={accessoryRow.accesory?.name ?? '-'}
                            />
                        ))}

                        {submission.handle && (
                            <BulletRow
                                text={`${submission.handle.name} (+${formatCurrency(submission.handle_price)} EUR)`}
                            />
                        )}
                    </div>

                    <div className="flex flex-col items-end justify-end self-stretch">
                        <p className="text-xs text-[#111827] uppercase">
                            Pret total
                        </p>
                        <p className="text-xl text-[#111827]">
                            {formatCurrency(submission.total_price)} EUR
                        </p>
                    </div>
                </div>
            </ConfigCard>
        </div>
    );
}
