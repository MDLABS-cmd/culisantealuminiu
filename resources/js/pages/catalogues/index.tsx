import { Head } from '@inertiajs/react';
import { CataloguesGrid } from '@/components/catalogues-grid';
import ConfiguratorLayout from '@/layouts/configurator-layout';
import type { BreadcrumbItem } from '@/types';
import type { Catalogue } from '@/types/models';

type CataloguesPageProps = {
    catalogues: Catalogue[];
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Cataloguri',
        href: '/cataloguri',
    },
];

export default function CataloguesPage({ catalogues }: CataloguesPageProps) {
    return (
        <ConfiguratorLayout breadcrumbs={breadcrumbs}>
            <Head title="Catalog" />

            <section className="pt-6 md:pt-10">
                <h1 className="poppins-medium text-center text-3xl text-[#111827] md:text-4xl">
                    Catalog
                </h1>
            </section>

            <CataloguesGrid catalogues={catalogues} />
        </ConfiguratorLayout>
    );
}
