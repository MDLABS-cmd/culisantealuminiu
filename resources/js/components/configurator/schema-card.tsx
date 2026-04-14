import type { ConfiguratorSchemaListItem } from '@/types';

type SchemaCardProps = {
    schema: ConfiguratorSchemaListItem;
    isSelected: boolean;
    isLoading?: boolean;
    onSelect: (schemaId: number) => void;
};

export function SchemaCard({
    schema,
    isSelected,
    isLoading = false,
    onSelect,
}: SchemaCardProps) {
    const imageUrl = schema.image_url;

    return (
        <div
            role="button"
            tabIndex={isLoading ? -1 : 0}
            onClick={() => onSelect(schema.id)}
            onKeyDown={(event) => {
                if (isLoading) {
                    return;
                }

                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    onSelect(schema.id);
                }
            }}
            aria-disabled={isLoading}
            className="flex cursor-pointer flex-col items-center gap-4 rounded-[20px] border-[1.5px] border-[#9ca3af] bg-[#f9fafb] p-6 shadow-[0_1px_4px_0_rgba(12,12,13,0.05)] transition-all duration-200 aria-disabled:cursor-not-allowed aria-disabled:opacity-50"
        >
            {/* Image Section */}
            <div className="h-30.75 w-full overflow-hidden rounded-xl bg-gray-200">
                {imageUrl ? (
                    <img
                        src={imageUrl}
                        alt={schema.name}
                        className="h-full w-full object-cover"
                    />
                ) : (
                    <div className="flex h-full w-full items-center justify-center bg-linear-to-br from-blue-100 to-blue-200">
                        <span className="text-sm font-medium text-blue-600">
                            No image
                        </span>
                    </div>
                )}
            </div>

            {/* Text Section */}
            <div className="w-full text-center">
                <p className="font-['Poppins'] text-[16px] leading-normal font-medium text-[#111827]">
                    {schema.name}
                </p>
            </div>

            {/* Button Section */}
            <button
                type="button"
                onClick={(e) => {
                    e.stopPropagation();
                    onSelect(schema.id);
                }}
                disabled={isLoading}
                className={`rounded-[14px] px-6 py-2 font-['Poppins'] text-[14px] leading-normal font-normal text-white shadow-[0_1px_4px_0_rgba(12,12,13,0.05)] transition-all duration-200 ${
                    isSelected
                        ? 'bg-[#4b5563] hover:bg-[#3f4854]'
                        : 'bg-[#6b7280] hover:bg-[#56626f]'
                }`}
            >
                {isSelected ? 'Ai selectat' : 'Selectează'}
            </button>
        </div>
    );
}
