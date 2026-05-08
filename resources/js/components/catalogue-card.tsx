import { Download, Eye } from 'lucide-react';
import type { ReactNode } from 'react';

// ─── Sub-component types ──────────────────────────────────────────────────────

type ThumbnailProps = {
    fileUrl: string | null;
};

type TitleAndDescriptionProps = {
    title: string;
    description: string | null;
};

type ActionsProps = {
    fileUrl: string | null;
};

// ─── Sub-components ───────────────────────────────────────────────────────────

function Thumbnail({ fileUrl }: ThumbnailProps) {
    return (
        <div className="h-72 overflow-hidden rounded-[14px] bg-[#d9d9d9] md:col-start-1 md:row-span-2 md:h-auto">
            {fileUrl && (
                <iframe
                    src={`${fileUrl}#toolbar=0&navpanes=0&scrollbar=0&view=FitH&page=1`}
                    className="pointer-events-none h-full w-full border-0"
                    title="PDF preview"
                />
            )}
        </div>
    );
}

function TitleAndDescription({ title, description }: TitleAndDescriptionProps) {
    return (
        <div className="flex flex-col gap-2 overflow-hidden md:col-start-2 md:row-start-1">
            <h2 className="poppins-medium truncate text-[16px] leading-none text-black">
                {title}
            </h2>
            <p className="poppins-regular line-clamp-4 text-[14px] leading-relaxed text-[#6b7280]">
                {description ??
                    'Catalog disponibil pentru consultare și descărcare.'}
            </p>
        </div>
    );
}

function Actions({ fileUrl }: ActionsProps) {
    return (
        <div className="flex flex-col flex-wrap items-center gap-3 md:flex-row">
            {fileUrl ? (
                <>
                    <a
                        href={fileUrl}
                        target="_blank"
                        rel="noreferrer"
                        className="poppins-regular inline-flex w-full items-center justify-center gap-2.5 rounded-[14px] border border-[#111827] px-6 py-2.5 text-[14px] leading-none text-[#111827] shadow-[0px_1px_4px_0px_rgba(12,12,13,0.05)] transition-colors hover:bg-[#111827] hover:text-white md:w-auto"
                    >
                        <Eye className="h-4 w-4 shrink-0" />
                        Vizualizează
                    </a>
                    <a
                        href={fileUrl}
                        download
                        className="poppins-regular inline-flex w-full items-center justify-center gap-2.5 rounded-[14px] bg-[#111827] px-6 py-2.5 text-[14px] leading-none text-white shadow-[0px_1px_2px_0px_rgba(12,12,13,0.05)] transition-colors hover:bg-[#222b3a] md:w-auto"
                    >
                        <Download className="h-3 w-3 shrink-0" />
                        Descarcă
                    </a>
                </>
            ) : (
                <p className="rounded-[14px] border border-dashed border-[#e7dcc6] px-4 py-3 text-[14px] text-[#6b7280]">
                    Fișierul PDF nu este disponibil încă.
                </p>
            )}
        </div>
    );
}

// ─── Root ─────────────────────────────────────────────────────────────────────

function CatalogueCardRoot({ children }: { children: ReactNode }) {
    return (
        <article className="grid grid-cols-1 grid-rows-[auto_1fr_auto] gap-4 overflow-hidden rounded-[14px] bg-white p-6 md:max-h-55 md:grid-cols-[187px_1fr] md:grid-rows-[1fr_auto]">
            {children}
        </article>
    );
}

// ─── Compound export ──────────────────────────────────────────────────────────

export const CatalogueCard = Object.assign(CatalogueCardRoot, {
    Thumbnail,
    TitleAndDescription,
    Actions,
});
