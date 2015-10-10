<?php

use Illuminate\Database\Seeder;
use \Toddish\Verify\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'delete_user']);
        Permission::create(['name' => 'delete_video']);
        Permission::create(['name' => 'delete_category']);
        Permission::create(['name' => 'edit_user']);
        Permission::create(['name' => 'edit_video']);
        Permission::create(['name' => 'edit_category']);
        Permission::create(['name' => 'add_category']);
        Permission::create(['name' => 'edit_comment']);
        Permission::create(['name' => 'delete_comment']);
        Permission::create(['name' => 'break_upload_limit']);
        Permission::create(['name' => 'break_max_filesize']);
    }
}
