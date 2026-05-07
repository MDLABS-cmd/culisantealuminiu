import { Head } from '@inertiajs/react';
import { CatalogueCard } from '@/components/catalogue-card';
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

            <section className="mx-auto mt-8 grid max-w-6xl gap-6 xl:grid-cols-2">
                {catalogues.map((catalogue) => (
                    <CatalogueCard key={catalogue.id}>
                        <CatalogueCard.Thumbnail fileUrl={catalogue.file_url} />
                        <CatalogueCard.TitleAndDescription
                            title={catalogue.title}
                            description={catalogue.description}
                        />
                        <CatalogueCard.Actions fileUrl={catalogue.file_url} />
                    </CatalogueCard>
                ))}
            </section>
        </ConfiguratorLayout>
    );
}
