type BulletRowProps = {
    text: string;
};

export function BulletRow({ text }: BulletRowProps) {
    return (
        <div className="flex items-center gap-2">
            <span className="size-1.5 shrink-0 rounded-full bg-[#111827]" />
            <p className="text-sm text-[#111827]">{text}</p>
        </div>
    );
}
