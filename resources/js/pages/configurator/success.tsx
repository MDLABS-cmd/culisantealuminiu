import { Head, Link, usePage } from '@inertiajs/react';

export default function ConfiguratorSuccess() {
    const { flash } = usePage().props;
    const isOrder = flash.submissionType === 'order';

    return (
        <>
            <Head title={isOrder ? 'Comandă trimisă' : 'Cerere trimisă'} />

            <div className="flex min-h-screen items-center justify-center bg-[#f9fafb] px-4">
                <div className="w-full max-w-md rounded-2xl border border-[#e5e7eb] bg-white px-8 py-12 text-center shadow-sm">
                    <div className="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#ecfdf5]">
                        <svg
                            className="h-8 w-8 text-[#10b981]"
                            fill="none"
                            viewBox="0 0 24 24"
                            strokeWidth={2}
                            stroke="currentColor"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M4.5 12.75l6 6 9-13.5"
                            />
                        </svg>
                    </div>

                    <h1 className="poppins-semibold text-2xl text-[#111827]">
                        {isOrder ? 'Comandă trimisă!' : 'Cerere trimisă!'}
                    </h1>

                    <p className="poppins-regular mt-3 text-sm text-[#6b7280]">
                        {isOrder
                            ? 'Comanda ta a fost înregistrată cu succes. Te vom contacta în curând pentru confirmare.'
                            : 'Cererea ta de ofertă a fost înregistrată cu succes. Te vom contacta în curând cu detaliile.'}
                    </p>

                    {flash.submissionId && (
                        <p className="poppins-regular mt-2 text-xs text-[#9ca3af]">
                            Număr referință: #{flash.submissionId}
                        </p>
                    )}

                    <Link
                        href="/"
                        className="poppins-medium mt-8 inline-block rounded-xl bg-[#111827] px-8 py-3 text-sm text-white transition hover:bg-[#1f2937]"
                    >
                        Configurație nouă
                    </Link>
                </div>
            </div>
        </>
    );
}
