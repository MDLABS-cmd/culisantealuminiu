<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

#[Signature('app:create-admin {email? : Admin email} {--name= : Admin name} {--password= : Admin password}')]
#[Description('Create or promote an admin user for Filament access.')]
class CreateAdminUserCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $isInteractive = $this->input->isInteractive();
        $emailArgument = (string) ($this->argument('email') ?? '');
        $passwordOption = (string) ($this->option('password') ?? '');

        if (! $isInteractive && ($emailArgument === '' || $passwordOption === '')) {
            $this->error('Non-interactive mode requires both email argument and --password option.');
            $this->line('Example: php artisan app:create-admin admin@example.com --password="secret123" --name="Administrator" --no-interaction');

            return self::FAILURE;
        }

        $email = $emailArgument !== ''
            ? $emailArgument
            : (string) text(
                label: 'Admin email',
                validate: ['required', 'email'],
            );

        $name = (string) ($this->option('name') ?: text(
            label: 'Admin name',
            default: 'Administrator',
            validate: ['required', 'string', 'max:255'],
        ));

        $passwordValue = $passwordOption !== ''
            ? $passwordOption
            : (string) password(
                label: 'Password for admin user',
                validate: ['required', 'string', 'min:8'],
            );

        $user = User::query()->where('email', $email)->first();

        if ($user) {
            $shouldPromote = $isInteractive
                ? confirm(
                    label: "User {$email} exists. Promote/update as admin?",
                    default: true,
                )
                : true;

            if (! $shouldPromote) {
                $this->warn('Operation cancelled.');

                return self::FAILURE;
            }

            $user->forceFill([
                'name' => $name,
                'password' => Hash::make($passwordValue),
                'is_admin' => true,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();

            $this->info("User {$email} updated and promoted to admin.");

            return self::SUCCESS;
        }

        User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($passwordValue),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->info("Admin user {$email} created.");

        return self::SUCCESS;
    }
}
