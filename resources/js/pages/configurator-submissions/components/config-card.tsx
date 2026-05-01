import type { ReactNode } from 'react';

type ConfigCardProps = {
    title: string;
    children: ReactNode;
};

export function ConfigCard({ title, children }: ConfigCardProps) {
    return (
        <div className="flex flex-col items-center gap-4 rounded-2xl bg-white p-6">
            <p className="text-xl text-[#111827]">{title}</p>
            <div className="w-full">{children}</div>
        </div>
    );
}
