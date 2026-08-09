<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createRolesAndPermissions();

        $superAdmin = User::query()->firstOrCreate(
            ['email' => 'superadmin@travelagent.test'],
            ['name' => 'Super Admin', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $superAdmin->syncRoles(['super_admin']);

        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@travelagent.test'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $admin->syncRoles(['admin']);

        $sales = User::query()->firstOrCreate(
            ['email' => 'sales@travelagent.test'],
            ['name' => 'Sales Staff', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $sales->syncRoles(['sales']);

        $finance = User::query()->firstOrCreate(
            ['email' => 'finance@travelagent.test'],
            ['name' => 'Finance Staff', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $finance->syncRoles(['finance']);

        $content = User::query()->firstOrCreate(
            ['email' => 'content@travelagent.test'],
            ['name' => 'Content Manager', 'password' => Hash::make('password'), 'email_verified_at' => now()]
        );
        $content->syncRoles(['content_manager']);
    }

    private function createRolesAndPermissions(): void
    {
        $modules = [
            'destinations', 'tour_packages', 'hotels', 'vehicles', 'promotions',
            'customers', 'bookings', 'payments', 'invoices',
            'reviews', 'blog_posts', 'blog_categories', 'galleries', 'inquiries',
            'users', 'settings',
        ];

        $permissions = [];
        foreach ($modules as $module) {
            foreach (['view', 'create', 'update', 'delete'] as $action) {
                $permissions[] = "{$module}.{$action}";
            }
        }

        foreach ($permissions as $permission) {
            Permission::query()->firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // super_admin: implicit full access via Gate::before in AppServiceProvider,
        // but we also give it every permission explicitly for consistency in Filament's
        // permission-based navigation checks.
        $superAdmin = Role::query()->firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions($permissions);

        $admin = Role::query()->firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(array_filter($permissions, fn ($p) => ! str_starts_with($p, 'users.')));

        $sales = Role::query()->firstOrCreate(['name' => 'sales', 'guard_name' => 'web']);
        $sales->syncPermissions([
            'destinations.view', 'tour_packages.view',
            'customers.view', 'customers.create', 'customers.update',
            'bookings.view', 'bookings.create', 'bookings.update',
            'promotions.view',
            'payments.view',
            'invoices.view', 'invoices.create',
            'inquiries.view', 'inquiries.update',
        ]);

        $finance = Role::query()->firstOrCreate(['name' => 'finance', 'guard_name' => 'web']);
        $finance->syncPermissions([
            'bookings.view',
            'payments.view', 'payments.update',
            'invoices.view', 'invoices.create', 'invoices.update',
            'customers.view',
        ]);

        $contentManager = Role::query()->firstOrCreate(['name' => 'content_manager', 'guard_name' => 'web']);
        $contentManager->syncPermissions([
            'destinations.view', 'destinations.create', 'destinations.update', 'destinations.delete',
            'tour_packages.view', 'tour_packages.create', 'tour_packages.update',
            'blog_posts.view', 'blog_posts.create', 'blog_posts.update', 'blog_posts.delete',
            'blog_categories.view', 'blog_categories.create', 'blog_categories.update', 'blog_categories.delete',
            'galleries.view', 'galleries.create', 'galleries.update', 'galleries.delete',
            'reviews.view', 'reviews.update', 'reviews.delete',
        ]);
    }
}
