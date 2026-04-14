import type { Auth } from '@/types/auth';
import type { System } from '@/types/models';

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            name: string;
            auth: Auth;
            sidebarOpen: boolean;
            activeSystems: System[];
            [key: string]: unknown;
        };
    }
}
