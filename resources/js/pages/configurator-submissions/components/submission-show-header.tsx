import { Link } from '@inertiajs/react';
import { ArrowLeftIcon } from 'lucide-react';
import { index as submissionsIndex } from '@/actions/App/Http/Controllers/ConfiguratorSubmissionController';
import { Button } from '@/components/ui/button';

type SubmissionShowHeaderProps = {
    submissionId: number;
    typeLabel: string;
    submittedAt: string;
};

export function SubmissionShowHeader({
    submissionId,
    typeLabel,
    submittedAt,
}: SubmissionShowHeaderProps) {
    return (
        <div className="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p className="text-xl font-medium text-[#111827]">
                    #{submissionId} - {typeLabel}
                </p>
                <p className="mt-1 text-sm text-[#6b7280]">
                    Trimisa la {submittedAt}
                </p>
            </div>

            <Button variant="outline" asChild>
                <Link href={submissionsIndex.url()}>
                    <ArrowLeftIcon className="size-4" />
                    Inapoi la lista
                </Link>
            </Button>
        </div>
    );
}
