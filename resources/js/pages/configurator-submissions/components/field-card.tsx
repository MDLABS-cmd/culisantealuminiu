type FieldCardProps = {
    label: string;
    value: string;
};

export function FieldCard({ label, value }: FieldCardProps) {
    return (
        <div className="flex flex-col gap-2">
            <p className="text-base font-medium text-[#111827]">{label}</p>
            <div className="rounded-xl border border-[#9ca3af] bg-white px-6 py-3 shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)]">
                <p className="text-sm text-[#111827]">{value || '-'}</p>
            </div>
        </div>
    );
}
