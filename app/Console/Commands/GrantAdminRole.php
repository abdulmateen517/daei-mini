<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GrantAdminRole extends Command
{
    protected $signature = 'app:grant-admin {email : The email address of the existing user}';

    protected $description = 'Grant the admin role to an existing user after confirmation';

    public function handle(): int
    {
        $user = User::query()->where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error('No user exists with that email address.');

            return self::FAILURE;
        }

        if ($user->isAdmin()) {
            $this->info('This user is already an admin.');

            return self::SUCCESS;
        }

        if (! $this->confirm("Grant admin access to {$user->email}?", false)) {
            $this->info('No changes were made.');

            return self::SUCCESS;
        }

        $user->forceFill(['role' => User::ROLE_ADMIN])->save();
        $this->info("Admin access granted to {$user->email}.");

        return self::SUCCESS;
    }
}
