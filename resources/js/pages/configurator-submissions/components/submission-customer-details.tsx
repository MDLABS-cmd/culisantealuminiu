import type { ConfiguratorSubmissionDetails } from '@/types';
import { FieldCard } from './field-card';

type SubmissionCustomerDetailsProps = {
    submission: ConfiguratorSubmissionDetails;
};

export function SubmissionCustomerDetails({
    submission,
}: SubmissionCustomerDetailsProps) {
    const customer = submission.customer;

    return (
        <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
            <FieldCard label="Companie" value={customer?.company_name ?? '-'} />

            <FieldCard
                label="Nume si Prenume"
                value={
                    `${customer?.first_name ?? ''} ${customer?.last_name ?? ''}`.trim() ||
                    '-'
                }
            />

            <FieldCard
                label="Adresa de livrare"
                value={customer?.address ?? '-'}
            />

            <FieldCard label="Telefon" value={customer?.phone ?? '-'} />

            <FieldCard label="Email" value={customer?.email ?? '-'} />

            <div className="flex flex-col gap-2">
                <p className="text-base font-medium text-[#111827]">
                    Observatii (optional)
                </p>
                <div className="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                    <p className="text-sm text-[#9ca3af]">
                        {submission.observations ?? 'Nu sunt observatii'}
                    </p>
                </div>
            </div>
        </div>
    );
}
