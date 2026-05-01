import { Head, Link } from '@inertiajs/react';
import { EyeIcon } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { DataTable } from '@/components/ui/data-table';
import type { ColumnDef } from '@/components/ui/data-table';
import AppLayout from '@/layouts/app-layout';
import { show as configuratorSubmissionShow } from '@/routes/configurator/submissions';
import type { ConfiguratorSubmissionWithSystemAndSchema } from '@/types';

type ConfiguratorSubmissionsPageProps = {
    submissions: ConfiguratorSubmissionWithSystemAndSchema[];
};

export default function ConfiguratorSubmissionsPage({
    submissions,
}: ConfiguratorSubmissionsPageProps) {
    const columns: ColumnDef<ConfiguratorSubmissionWithSystemAndSchema>[] = [
        {
            accessorKey: 'id',
            header: 'ID',
        },
        {
            accessorKey: 'system.name',
            header: 'Sistem',
        },
        {
            accessorKey: 'schema.name',
            header: 'Schemă',
        },
        {
            accessorKey: 'type',
            header: 'Tip',
            render: (value) =>
                value === 'order' ? 'Comandă' : 'Cerere ofertă',
        },
        {
            accessorKey: 'total_price',
            header: 'Preț total',
        },
        {
            accessorKey: 'submitted_at',
            header: 'Data trimiterii',
        },
        {
            header: 'Acțiuni',
            accessorKey: 'actions',
            render: (_, row) => {
                return (
                    <Button
                        variant="ghost"
                        size="icon"
                        aria-label="Vezi detalii"
                        asChild
                    >
                        <Link
                            href={configuratorSubmissionShow.url({
                                submission: row.id,
                            })}
                        >
                            <EyeIcon className="size-4" />
                        </Link>
                    </Button>
                );
            },
        },
    ];

    return (
        <AppLayout>
            <Head title="Configurări" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <DataTable columns={columns} data={submissions} />
            </div>
        </AppLayout>
    );
}
