<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Users\Domain\Enums\UserRole;
use App\Shared\Domain\Enums\SupportedLocale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => UserRole::ADMIN,
                'phone' => '+10000000000',
                'is_active' => true,
                'preferred_locale' => SupportedLocale::EN,
            ]
        );
    }
}
