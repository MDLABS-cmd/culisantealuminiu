import type { Auth } from '@/types/auth';
import type { System, CustomOption } from '@/types/models';
import type { TopbarSettings } from '@/types/ui';

declare module '@inertiajs/core' {
    export interface InertiaConfig {
        sharedPageProps: {
            name: string;
            auth: Auth;
            sidebarOpen: boolean;
            activeSystems: System[];
            topbar: TopbarSettings;
            activeCustomOptions: CustomOption[];
            flash: {
                submissionId: number | null;
                submissionType: string | null;
            };
            [key: string]: unknown;
        };
    }
}
