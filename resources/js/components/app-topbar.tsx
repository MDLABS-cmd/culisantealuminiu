import { Link } from '@inertiajs/react';
import { FileText, Mail, Phone } from 'lucide-react';
import { Button } from '@/components/ui/button';

type AppTopbarProps = {
    phoneNumber: string;
    email: string;
    catalogHref: string;
};

export function AppTopbar({ phoneNumber, email, catalogHref }: AppTopbarProps) {
    const normalizedPhoneNumber = phoneNumber.trim();
    const normalizedEmail = email.trim();

    if (!normalizedPhoneNumber && !normalizedEmail && !catalogHref) {
        return null;
    }

    return (
        <div className="border-b border-[#d9d9d9] bg-white">
            <div className="mx-auto flex items-start justify-between px-4 py-3 md:h-12 md:items-center md:px-8 md:py-0 xl:px-30">
                <div className="flex flex-col gap-1.5 md:flex-row md:items-center md:gap-6">
                    {normalizedPhoneNumber && (
                        <a
                            href={`tel:${normalizedPhoneNumber}`}
                            className="inline-flex items-center gap-2 text-[#111827] transition-colors hover:text-[#4b5563]"
                        >
                            <span className="hidden h-7 w-7 items-center justify-center rounded-full border border-[#d7d7d7] text-[#111827] md:inline-flex">
                                <Phone className="h-3.5 w-3.5" />
                            </span>
                            <span className="inline-flex items-center gap-2 leading-none">
                                <span className="poppins-medium text-[11px] tracking-[0.14em] text-[#6b7280] uppercase">
                                    Telefon
                                </span>
                                <span className="poppins-medium text-sm text-[#111827]">
                                    {normalizedPhoneNumber}
                                </span>
                            </span>
                        </a>
                    )}

                    {normalizedEmail && (
                        <a
                            href={`mailto:${normalizedEmail}`}
                            className="inline-flex items-center gap-2 text-[#111827] transition-colors hover:text-[#4b5563]"
                        >
                            <span className="hidden h-7 w-7 items-center justify-center rounded-full border border-[#d7d7d7] text-[#111827] md:inline-flex">
                                <Mail className="h-3.5 w-3.5" />
                            </span>
                            <span className="inline-flex items-center gap-2 leading-none">
                                <span className="poppins-medium text-[11px] tracking-[0.14em] text-[#6b7280] uppercase">
                                    Email
                                </span>
                                <span className="poppins-medium text-sm text-[#111827]">
                                    {normalizedEmail}
                                </span>
                            </span>
                        </a>
                    )}
                </div>

                <Button variant="customOutline" asChild>
                    <Link href={catalogHref} prefetch>
                        <FileText className="h-4 w-4" />
                        Catalog
                    </Link>
                </Button>
            </div>
        </div>
    );
}
