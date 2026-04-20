import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useConfigurator } from '@/hooks/use-configurator';
import { cn } from '@/lib/utils';
import type { OrderState } from '@/types';
import { Section } from './section';

type TextFieldKey = Exclude<
    keyof OrderState,
    | 'createAccount'
    | 'companyName'
    | 'observations'
    | 'password'
    | 'confirmPassword'
>;

type NullableTextFieldKey = Extract<
    keyof OrderState,
    'companyName' | 'observations' | 'password' | 'confirmPassword'
>;

type FieldProps = {
    id: string;
    label: string;
    required?: boolean;
    children: React.ReactNode;
    className?: string;
};

function Field({ id, label, required, children, className }: FieldProps) {
    return (
        <div className={cn('flex flex-col gap-2', className)}>
            <Label
                htmlFor={id}
                className="font-['Poppins'] text-sm font-medium text-[#111827]"
            >
                {label}
                {required && <span className="text-[#ef4444]"> *</span>}
            </Label>
            {children}
        </div>
    );
}

export default function ConfiguratorOrderForm() {
    const { orderState, setOrderState } = useConfigurator();

    const updateTextField = (field: TextFieldKey, value: string) => {
        setOrderState({
            ...orderState,
            [field]: value,
        });
    };

    const updateNullableTextField = (
        field: NullableTextFieldKey,
        value: string,
    ) => {
        setOrderState({
            ...orderState,
            [field]: value.trim() ? value : null,
        });
    };

    const handleCreateAccountChange = (checked: boolean) => {
        setOrderState({
            ...orderState,
            createAccount: checked,
            password: checked ? orderState.password : null,
            confirmPassword: checked ? orderState.confirmPassword : null,
        });
    };

    return (
        <Section
            title="Confirmare comanda"
            description="Completează datele de contact pentru a finaliza cererea de ofertă sau comanda."
            titleClassName="text-center"
            descriptionClassName="text-center"
        >
            <form className="mt-6 space-y-6">
                <div className="grid gap-4 md:grid-cols-2">
                    <Field id="companyName" label="Companie">
                        <Input
                            id="companyName"
                            name="companyName"
                            autoComplete="organization"
                            placeholder="Numele companiei"
                            value={orderState.companyName ?? ''}
                            onChange={(event) =>
                                updateNullableTextField(
                                    'companyName',
                                    event.target.value,
                                )
                            }
                        />
                    </Field>

                    <Field id="phone" label="Telefon" required>
                        <Input
                            id="phone"
                            name="phone"
                            type="tel"
                            autoComplete="tel"
                            placeholder="07xx xxx xxx"
                            required
                            value={orderState.phone}
                            onChange={(event) =>
                                updateTextField('phone', event.target.value)
                            }
                        />
                    </Field>

                    <Field id="firstName" label="Prenume" required>
                        <Input
                            id="firstName"
                            name="firstName"
                            autoComplete="given-name"
                            placeholder="Prenume"
                            required
                            value={orderState.firstName}
                            onChange={(event) =>
                                updateTextField('firstName', event.target.value)
                            }
                        />
                    </Field>

                    <Field id="lastName" label="Nume" required>
                        <Input
                            id="lastName"
                            name="lastName"
                            autoComplete="family-name"
                            placeholder="Nume"
                            required
                            value={orderState.lastName}
                            onChange={(event) =>
                                updateTextField('lastName', event.target.value)
                            }
                        />
                    </Field>

                    <Field
                        id="email"
                        label="Email"
                        required
                        className="md:col-span-2"
                    >
                        <Input
                            id="email"
                            name="email"
                            type="email"
                            autoComplete="email"
                            placeholder="adresa@email.ro"
                            required
                            value={orderState.email}
                            onChange={(event) =>
                                updateTextField('email', event.target.value)
                            }
                        />
                    </Field>

                    <Field
                        id="address"
                        label="Adresă"
                        required
                        className="md:col-span-2"
                    >
                        <Input
                            id="address"
                            name="address"
                            autoComplete="street-address"
                            placeholder="Stradă, număr, localitate"
                            required
                            value={orderState.address}
                            onChange={(event) =>
                                updateTextField('address', event.target.value)
                            }
                        />
                    </Field>

                    <Field
                        id="observations"
                        label="Observații"
                        className="md:col-span-2"
                    >
                        <textarea
                            id="observations"
                            name="observations"
                            rows={4}
                            placeholder="Detalii suplimentare despre livrare, montaj sau preferințe."
                            value={orderState.observations ?? ''}
                            onChange={(event) =>
                                updateNullableTextField(
                                    'observations',
                                    event.target.value,
                                )
                            }
                            className="min-h-28 w-full rounded-xl border border-[#e5e7eb] bg-white px-6 py-3 font-['Poppins'] text-sm text-[#111827] transition-all outline-none placeholder:text-[#9ca3af] focus-visible:border-[#3b82f6] focus-visible:ring-1 focus-visible:ring-[#3b82f6]"
                        />
                    </Field>
                </div>

                <div className="rounded-xl border border-[#e5e7eb] bg-[#f9fafb] p-4">
                    <label className="flex items-start gap-3">
                        <input
                            id="createAccount"
                            name="createAccount"
                            type="checkbox"
                            checked={orderState.createAccount}
                            onChange={(event) =>
                                handleCreateAccountChange(event.target.checked)
                            }
                            className="mt-1 h-4 w-4 rounded border-[#d1d5db] text-[#111827] focus:ring-[#3b82f6]"
                        />
                        <span className="space-y-1">
                            <Label
                                htmlFor="createAccount"
                                className="font-['Poppins'] text-sm font-medium text-[#111827]"
                            >
                                Creează-mi și un cont
                            </Label>
                            <span className="block font-['Poppins'] text-sm text-[#6b7280]">
                                Vei putea reveni ulterior la configurațiile tale
                                și la istoricul cererilor.
                            </span>
                        </span>
                    </label>

                    {orderState.createAccount && (
                        <div className="mt-4 grid gap-4 md:grid-cols-2">
                            <Field id="password" label="Parolă" required>
                                <Input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autoComplete="new-password"
                                    placeholder="Alege o parolă"
                                    required={orderState.createAccount}
                                    value={orderState.password ?? ''}
                                    onChange={(event) =>
                                        updateNullableTextField(
                                            'password',
                                            event.target.value,
                                        )
                                    }
                                />
                            </Field>

                            <Field
                                id="confirmPassword"
                                label="Confirmă parola"
                                required
                            >
                                <Input
                                    id="confirmPassword"
                                    name="confirmPassword"
                                    type="password"
                                    autoComplete="new-password"
                                    placeholder="Reintrodu parola"
                                    required={orderState.createAccount}
                                    value={orderState.confirmPassword ?? ''}
                                    onChange={(event) =>
                                        updateNullableTextField(
                                            'confirmPassword',
                                            event.target.value,
                                        )
                                    }
                                />
                            </Field>
                        </div>
                    )}
                </div>
            </form>
        </Section>
    );
}
