<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'products.view', 'products.create', 'products.update', 'products.delete',
            'categories.view', 'categories.create', 'categories.update', 'categories.delete',
            'orders.view', 'orders.update',
            'users.view', 'users.update', 'users.delete',
            'view payments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $vendorRole = Role::firstOrCreate(['name' => 'vendor']);
        Role::firstOrCreate(['name' => 'customer']);

        $adminRole->syncPermissions(Permission::all());
        $vendorRole->syncPermissions([
            'products.view', 'products.create', 'products.update',
            'orders.view', 'orders.update',
        ]);
    }
}
