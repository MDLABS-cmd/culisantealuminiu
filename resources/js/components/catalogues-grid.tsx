import { CatalogueCard } from '@/components/catalogue-card';
import type { Catalogue } from '@/types/models';
import { EmptyState } from './ui/empty-state';

type Props = {
    catalogues: Catalogue[];
};

export function CataloguesGrid({ catalogues }: Props) {
    if (catalogues.length === 0) {
        return (
            <EmptyState
                title="Niciun catalog încărcat"
                description="Momentan nu există niciun catalog încărcat în sistem."
            />
        );
    }

    return (
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
    );
}
