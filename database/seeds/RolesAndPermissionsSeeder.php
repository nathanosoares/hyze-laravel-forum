<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $moderatorPermissions = [
            'chatter delete any thread',
            'chatter edit any thread',
            'chatter delete any post',
            'chatter edit any post'
        ];

        $administratorPermissions = [
            'chatter force delete any thread',
            'chatter force delete any post',
            'chatter promote thread'
        ];

        $allPermissions = array_merge($moderatorPermissions, $administratorPermissions);

        foreach ($allPermissions as $perm) {
            Permission::create(['name' => $perm]);
        }

        $role = Role::create(['name' => 'moderator']);
        $role->givePermissionTo($moderatorPermissions);

        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo($allPermissions);

        User::find(1)->assignRole('administrator');
    }
}
