<?php

use Illuminate\Database\Seeder;
use \Toddish\Verify\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mod = Role::create(['name' => 'Moderator', 'level' => 7]);
        $perms = \Toddish\Verify\Models\Permission::all(['id']);
        $mod->permissions()->sync($perms);
    }
}
