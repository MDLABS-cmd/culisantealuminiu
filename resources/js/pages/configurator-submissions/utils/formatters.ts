import type { ConfiguratorSubmissionDetails } from '@/types';

export function formatCurrency(value: string | number): string {
    const numericValue = Number(value);

    if (!Number.isFinite(numericValue)) {
        return '0,00';
    }

    return new Intl.NumberFormat('ro-RO', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(numericValue);
}

export function formatSubmittedAt(value: string): string {
    const date = new Date(value);

    if (Number.isNaN(date.getTime())) {
        return '-';
    }

    return new Intl.DateTimeFormat('ro-RO', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    }).format(date);
}

export function normalizeHex(hexCode: string | null): string {
    if (!hexCode) {
        return '#d9d9d9';
    }

    return hexCode.startsWith('#') ? hexCode : `#${hexCode}`;
}

export function getSubmissionTypeLabel(
    type: ConfiguratorSubmissionDetails['type'],
): string {
    return type === 'order' ? 'Comanda' : 'Cerere oferta';
}
