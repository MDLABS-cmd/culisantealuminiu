import AuthLayoutTemplate from '@/layouts/auth/auth-split-layout';
import ConfiguratorLayout from './configurator-layout';

export default function AuthLayout({
    children,
    title,
    description,
    ...props
}: {
    children: React.ReactNode;
    title: string;
    description: string;
}) {
    return (
        <ConfiguratorLayout noPadding>
            <AuthLayoutTemplate
                title={title}
                description={description}
                {...props}
            >
                {children}
            </AuthLayoutTemplate>
        </ConfiguratorLayout>
    );
}
