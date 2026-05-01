import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import type { BreadcrumbItem, ConfiguratorSubmissionDetails } from '@/types';
import { SubmissionConfigurationGrid } from './components/submission-configuration-grid';
import { SubmissionCustomerDetails } from './components/submission-customer-details';
import { SubmissionShowHeader } from './components/submission-show-header';
import { formatSubmittedAt, getSubmissionTypeLabel } from './utils/formatters';

type ConfiguratorSubmissionShowPageProps = {
    submission: ConfiguratorSubmissionDetails;
};

export default function ConfiguratorSubmissionShowPage({
    submission,
}: ConfiguratorSubmissionShowPageProps) {
    const submissionTypeLabel = getSubmissionTypeLabel(submission.type);
    const submittedAt = formatSubmittedAt(submission.submitted_at);

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Tablou de bord',
            href: dashboard.url(),
        },
        {
            title: `#${submission.id}`,
            href: '#',
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Configurare #${submission.id}`} />

            <div className="flex h-full flex-1 flex-col gap-8 overflow-x-auto rounded-xl p-4">
                <SubmissionShowHeader
                    submissionId={submission.id}
                    typeLabel={submissionTypeLabel}
                    submittedAt={submittedAt}
                />

                <SubmissionCustomerDetails submission={submission} />

                <SubmissionConfigurationGrid submission={submission} />
            </div>
        </AppLayout>
    );
}
