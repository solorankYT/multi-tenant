<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantSeeder extends Seeder
{
    public function run()
    {
        $tenants = [
            [
                'name' => 'UPLB',
                'admin' => [
                    'name' => 'Admin UPLB',
                    'email' => 'admin@uplb.com',
                    'password' => 'password123',
                ]
            ],
            [
                'name' => 'UPLM',
                'admin' => [
                    'name' => 'Admin UPLM',
                    'email' => 'admin@uplm.com',
                    'password' => 'password123',
                ]
            ],
        ];

        foreach ($tenants as $tenantData) {
            // Create the tenant
            $tenant = Tenant::create([
                'id' => Str::uuid(),
                'name' => $tenantData['name'], // Set tenant name
            ]);

            // Create the admin user for this tenant
            $adminUser = User::create([
                'name' => $tenantData['admin']['name'],
                'email' => $tenantData['admin']['email'],
                'password' => Hash::make($tenantData['admin']['password']),
            ]);

            // Attach the user to the tenant
            $tenant->users()->attach($adminUser->id);

            $this->command->info("Tenant with ID {$tenant->id} and admin {$adminUser->name} seeded.");
        }
    }
}
