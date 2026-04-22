<?php

namespace App\Services\ConfiguratorSubmission;

use App\Models\User;
use InvalidArgumentException;

class ResolveSubmissionUserService
{
    /**
     * Resolve the user associated with the submission.
     *
     * @param  array<string, mixed>  $order
     */
    public function resolve(array $order, ?User $authenticatedUser = null): ?User
    {
        if ($authenticatedUser !== null) {
            return $authenticatedUser;
        }

        $createAccount = (bool) ($order['create_account'] ?? false);

        if (! $createAccount) {
            return null;
        }

        $email = (string) ($order['email'] ?? '');
        $password = (string) ($order['password'] ?? '');

        if ($email === '' || $password === '') {
            throw new InvalidArgumentException('Email and password are required when create_account is enabled.');
        }

        return User::firstOrCreate(
            ['email' => $email],
            [
                'name' => trim(((string) ($order['first_name'] ?? '')) . ' ' . ((string) ($order['last_name'] ?? ''))),
                'password' => $password,
            ],
        );
    }
}
