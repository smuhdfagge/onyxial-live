<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(SiteContentSeeder::class);

        // First admin account. Set ADMIN_EMAIL / ADMIN_PASSWORD in .env before seeding,
        // or a random password is generated and printed once below.
        $email = env('ADMIN_EMAIL', 'admin@onyxial.com');
        if (! User::where('email', $email)->exists()) {
            $password = env('ADMIN_PASSWORD') ?: Str::password(14, symbols: false);
            User::create([
                'name' => env('ADMIN_NAME', 'Site Administrator'),
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]);

            $this->command?->newLine();
            $this->command?->info('Admin account created');
            $this->command?->line('  Login:    '.url('/admin/login'));
            $this->command?->line('  Email:    '.$email);
            if (! env('ADMIN_PASSWORD')) {
                $this->command?->line('  Password: '.$password.'   (shown once, please change it after signing in)');
            }
            $this->command?->newLine();
        }
    }
}
