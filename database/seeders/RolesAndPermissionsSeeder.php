<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'create cars']);
        Permission::create(['name' => 'create auctions']);
        Permission::create(['name' => 'approve auctions']);
        Permission::create(['name' => 'bid on auctions']);
        $admin = Role::create(['name' => 'admin']);
        $seller = Role::create(['name' => 'seller']);
        $user = Role::create(['name' => 'user']);
        $admin->givePermissionTo(Permission::all());
        $seller->givePermissionTo(['create cars', 'create auctions']);
        $user->givePermissionTo(['bid on auctions']);
    }
}
