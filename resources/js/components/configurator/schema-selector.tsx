import type { ConfiguratorSchemaListItem } from '@/types';
import { SchemaCard } from './schema-card';

type SchemaSelectorProps = {
    schemas: ConfiguratorSchemaListItem[];
    selectedSchemaId: number | null;
    loading: boolean;
    onSelect: (schemaId: number) => void;
};

export function SchemaSelector({
    schemas,
    selectedSchemaId,
    loading,
    onSelect,
}: SchemaSelectorProps) {
    if (loading) {
        return (
            <div className="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                {Array.from({ length: 4 }).map((_, index) => (
                    <div
                        key={index}
                        className="h-64 animate-pulse rounded-[20px] border-[1.5px] border-[#e5e7eb] bg-[#f5f5f4]"
                    />
                ))}
            </div>
        );
    }

    if (schemas.length === 0) {
        return (
            <p className="mt-3 text-sm text-[#6b7280]">
                Select a system to see available schemas.
            </p>
        );
    }

    return (
        <div className="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            {schemas.map((schema) => (
                <SchemaCard
                    key={schema.id}
                    schema={schema}
                    isSelected={selectedSchemaId === schema.id}
                    isLoading={loading}
                    onSelect={onSelect}
                />
            ))}
        </div>
    );
}
